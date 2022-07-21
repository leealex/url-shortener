<?php

/**
 * @var yii\web\View $this
 * @var \app\models\Url $model
 */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'UrlShortener';
?>
<div class="site-index">
  <div class="jumbotron text-center bg-transparent">
    <h1 class="display-4">Make it short!</h1>
  </div>
    <?php $form = ActiveForm::begin(['fieldConfig' => ['template' => "{input}"]]); ?>
  <div class="row justify-content-md-center">
    <div class="col-md-6">
      <div class="input-group mb-3">
          <?= $form->field($model, 'original', ['options' => ['tag' => false]])
              ->textInput(['class' => 'form-control', 'placeholder' => 'Paste your url here'])
              ->label(false) ?>
          <?= Html::submitButton('Go!', ['class' => 'btn btn-success']) ?>
      </div>
    </div>
  </div>
    <?php ActiveForm::end(); ?>

    <?php if ($model->shortUrl) { ?>
      <div class="row justify-content-md-center">
        <div class="col-md-6">
          <div class="alert alert-success" role="alert">
            <p>Your short url: <?= Html::a($model->shortUrl, $model->shortUrl, ['target' => '_blank']) ?></p>
            <p>Statistics: <?= Html::a($model->statsUrl, $model->statsUrl, ['target' => '_blank']) ?></p>
          </div>
        </div>
      </div>
    <?php } ?>

</div>
<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>