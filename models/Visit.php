<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $url_id
 * @property int|null $created_at
 *
 * @property Url $url
 */
class Visit extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['url_id', 'required']
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

    /**
     * @return ActiveQuery
     */
    public function getUrl(): ActiveQuery
    {
        return $this->hasOne(Url::class, ['id' => 'url_id']);
    }
}
