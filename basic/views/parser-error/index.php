<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParserErrorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Parser Errors');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parser-error-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>        
        
		
		<?= Html::a(Yii::t('app', 'Delete All Errors'), ['delete-all'], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [          
            [
				'class' => 'yii\grid\SerialColumn',
				'options' => ['width' => '60'],
			],  
			
            //'id',
            'registration_date:datetime',
            [
				'attribute' => 'url',	
				'format' => 'raw',								
				'content' => function($data)
				{					
					return Html::a($data->domain, ['site/redirect', 'url' => $data->url], ['target' => '_blank']);
				},					
			],       
            'message:ntext',
			/*
			[
				'attribute' => 'id_parser_rule',	
				'format' => 'raw',								
				'content' => function($data)
				{		
					if (!empty($data->parserRule))
						return Html::a($data->parserRule->title, ['parser-rule/view', 'id' => $data->parserRule->id], ['target' => '_blank']);
					else
						return null;
				},					
			],  
			*/

            [
				'class' => 'yii\grid\ActionColumn', 
				'template' => '{view} {delete}',				
				'options' => ['width' => '50'],			 
			
			],
        ],
    ]); ?>
</div>
