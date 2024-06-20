<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
	
	
	<?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
	
	<?php if (Yii::$app->user->identity->IsAdmin == true) {?>	
	<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>	
	<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>		
	<?= $form->field($model, 'id_user_type')->dropDownList(ArrayHelper::map(app\models\UserType::find()->orderby(['title'=>'title asc'])->all(), 'id', 'title')) ?>			
    <?= $form->field($model, 'status')->dropDownList([app\models\User::STATUS_ACTIVE => Yii::t('app', 'Active User'), app\models\User::STATUS_REGISTRED => Yii::t('app', 'Registred User'), app\models\User::STATUS_DELETED => Yii::t('app', 'Deleted User')]) ?>		
	<?php } ?>	
	
	<?= $form->field($model, 'password_new')->passwordInput() ?>		
	
	<?= $form->field($model, 'password_confirmation')->passwordInput() ?>		
	

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
