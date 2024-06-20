<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

				function GetStatusTitle ($data)
				{
					$var = $data->status;					
					if ($var == app\models\User::STATUS_ACTIVE)
					{						
						return Yii::t('app', 'Active User');
					}					
					if ($var == app\models\User::STATUS_DELETED)
					{						
						return Yii::t('app', 'Deleted User');
					}		
					if ($var == app\models\User::STATUS_REGISTRED)
					{						
						return Yii::t('app', 'Registred User');
					}						
					return '';
				}

?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<?php if (Yii::$app->user->identity->IsAdmin == true) {?>	
		<?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
		<?php } ?>
		<?php if (Yii::$app->user->identity->id == $model->id) {?>	
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?php } ?>
		<?php if (Yii::$app->user->identity->IsAdmin == true) {?>	
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
		<?php } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [              
			'last_name',   
			'first_name',   
			'middle_name',            
			'phone', 
			//'username',  			
			'email:email',  				
			[
				'attribute' => 'id_user_type',						
				'value' => empty ($model->idUserType) == false ? $model->idUserType->title : '',
			],
			[
				'attribute' => 'status',						
				'value' => GetStatusTitle ($model),
			],   
            //'created_at:date',
            //'updated_at:date',
        ],
    ]) ?>

</div>
