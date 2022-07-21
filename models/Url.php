<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $token
 * @property string $original
 * @property int|null $created_at
 *
 * @property string $shortUrl
 * @property string $statsUrl
 * @property Visit[] $visits
 * @property int $visitsCount
 */
class Url extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['token', 'unique'],
            ['original', 'required'],
            ['token', 'string', 'min' => 5, 'max' => 5],
            ['original', 'string', 'min' => 3, 'max' => 2000],
            ['original', 'url']
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false
            ]
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->token = $this->generateToken();

        return true;
    }

    /**
     * @return string
     */
    private function generateToken(): string
    {
        $token = '';
        $symbols = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'), ['_', '-']);
        $max = count($symbols) - 1;
        for ($i = 0; $i < 5; $i++) {
            $token .= $symbols[mt_rand(0, $max)];
        }
        // Если такой токен уже есть, генерим новый
        if (Url::find()->where(['token' => $token])->exists()) {
            return  $this->generateToken();
        }

        return $token;
    }

    /**
     * @return string|null
     */
    public function getShortUrl(): ?string
    {
        if ($this->token) {
            return Yii::$app->request->hostInfo . '/' . $this->token;
        }
        return null;
    }

    /**
     * @return string|null
     */
    public function getStatsUrl(): ?string
    {
        if ($this->token) {
            return Yii::$app->request->hostInfo . '/statistics/' . $this->token;
        }
        return null;
    }

    /**
     * @return ActiveQuery
     */
    public function getVisits(): ActiveQuery
    {
        return $this->hasMany(Visit::class, ['url_id' => 'id']);
    }

    /**
     * Total visits amount
     * @return null
     */
    public function getVisitsCount(): ?int
    {
        return (int)$this->getVisits()->count();
    }
}
