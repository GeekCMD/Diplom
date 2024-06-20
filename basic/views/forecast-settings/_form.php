<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ForecastSettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forecast-settings-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'forecast_data_size')->textInput() ?>

    <?= $form->field($model, 'forecast_size')->textInput() ?>
   
    <?= $form->field($model, 'forecast_alpha')->textInput() ?>

    <?= $form->field($model, 'forecast_beta')->textInput() ?>

    

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
