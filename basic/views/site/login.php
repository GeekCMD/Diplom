<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
   
	
	
    <div class="row">
        <div class="col-lg-4">
			
		</div>
		<div class="col-lg-4">		
			<h1><?= Html::encode($this->title) ?></h1>
			<p><?= Yii::t('app', 'Please fill out the following fields to login:') ?></p>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
			
			    <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    <?= Yii::t('app', 'If you forgot your password you can') . ' ' . Html::a(Yii::t('app', 'reset it'), ['site/request-password-reset']) ?>.
                </div>
				
				<div style="color:#999;margin:1em 0">
                    <?php 
						echo Html::a(Yii::t('app', 'Get registration'), ['site/signup']); 
					?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>		
		<div class="col-lg-4">
			
		</div>
		
    </div>
</div>
