<?php

/**
 * @var yii\web\View $this
 * @var \app\models\Url $model
 * @var array $statistics
 */

$this->title = 'UrlShortener';
?>
<div class="site-index">
  <div class="jumbotron text-center bg-transparent">
    <h1 class="display-4">Statistics for <?= $model->token ?></h1>
    <p>Token created at <?= date('d.m.y', $model->created_at) ?></p>
  </div>

  <div class="row justify-content-md-center">
    <div class="col-md-6">
      <table class="table">
        <tr>
          <th>Date</th>
          <th>Visits</th>
        </tr>
          <?php foreach ($statistics as $day => $visits) { ?>
            <tr>
              <td><?= $day ?></td>
              <td><?= $visits ?></td>
            </tr>
          <?php } ?>
      </table>
    </div>
  </div>
</div>
