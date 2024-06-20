<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
//use kartik\export\ExportMenu;
//use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<?php if (Yii::$app->user->identity->IsAdmin) {?>	
    <p>
		
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	<?php } ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
				'class' => 'yii\grid\SerialColumn',
				'options' => ['width' => '65'],
			],   
			'last_name',
			'first_name',
			'middle_name',
			//'phone',			
			//'username',   					
			[
				'attribute' => 'id_user_type',				
				'filter' => ArrayHelper::map(app\models\UserType::find()->orderby(['title'=>'title asc'])->all(), 'id', 'title'),
				'content' => function($data)
				{
					$var = $data->idUserType;					
					if (empty($var) == false)
					{						
						return $var->title;
					}										
					return '';
				},
			
			],   
			[
				'attribute' => 'status',				
				'filter' => [app\models\User::STATUS_ACTIVE => Yii::t('app', 'Active User'), app\models\User::STATUS_REGISTRED => Yii::t('app', 'Registred User'), app\models\User::STATUS_DELETED => Yii::t('app', 'Deleted User')],
				'content' => function($data)
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
				},
			
			],   
			[
				'class' => 'yii\grid\ActionColumn', 				
				'options' => ['width' => (Yii::$app->user->identity->IsAdmin ? '70' : '25')],
				'template' => ((Yii::$app->user->identity->IsAdmin) ? '{view} {update} {delete}' : '{view}'),
			],	
        ],
    ]); ?>

</div>
