<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ForecastSettings */

$this->title = Yii::t('app', 'Update Forecast Settings: {nameAttribute}', [
    'nameAttribute' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' =>Yii::t('app', 'Forecast Settings'), 'url' => ['view']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="forecast-settings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
