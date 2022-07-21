<?php

namespace app\controllers;

use app\models\Url;
use app\models\Visit;
use app\services\Statistics;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Main controller for urls handling
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $model = new Url;
        if ($this->request->isPost) {
            if (!$model->load($this->request->post()) || !$model->save()) {
                Yii::$app->session->setFlash('danger', 'Could not create short url');
            }
        }
        return $this->render('index', ['model' => $model]);
    }

    /**
     * @param string $token
     * @return Response
     */
    public function actionGo(string $token): Response
    {
        // Ищем модель с учетом регистра
        if (!$model = Url::find()->where(['like binary', 'token', $token])->one()) {
            Yii::$app->session->setFlash('danger', 'Token not found');
            return $this->redirect(['site/index']);
        }
        $model->link('visits', new Visit);
        return $this->redirect($model->original);
    }

    /**
     * @param string $token
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionStatistics(string $token): string
    {
        if (!$model = Url::findOne(['token' => $token])) {
            throw new NotFoundHttpException('Token not found');
        }
        return $this->render('statistics', ['model' => $model, 'statistics' => Statistics::get($model)]);
    }
}
