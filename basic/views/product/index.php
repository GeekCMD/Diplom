<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
		<?= Html::a(Yii::t('app', 'Parse All Products'), ['parse-all'], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => Yii::t('app', 'Confirm the operation?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
			
			
			[
				'attribute' => 'min_cost',							
				'contentOptions' => ['style' => ['text-align' => 'right']],
				'options' => ['width' => '100px'],	
			], 
			
			[
				'attribute' => 'max_cost',						
				'contentOptions' => ['style' => ['text-align' => 'right']],						
				'options' => ['width' => '100px'],	
			], 
			
			[
				'attribute' => 'main_cost',					
				'options' => ['width' => '100px'],	
				'contentOptions' => function($model)
                    {					
						
						$min_cost = $model->min_cost;
						$max_cost = $model->max_cost;
						$main_cost = $model->main_cost;					
						
						
						if ($main_cost <= $min_cost)
							$color = 'yellowgreen';
						if ($min_cost < $main_cost && $main_cost < $max_cost)
							$color = '#5bc0de';
						if ($max_cost <= $main_cost)
							$color = 'red';						
						
						return ['style' => ['background' => $color, 'text-align' => 'right']];						
                    },
			], 		
			
			//'link_count',
			//'loaded_link_count',
			//'error_link_count',
			
			[
				'attribute' => 'loaded_link_count',					
				'content' => function($model)
				{		
					$link_count = $model->link_count;
					$loaded_link_count = $model->loaded_link_count;					
					return Yii::t('app', 'Loaded {loadedLinkCount} from {linkCount}', ['loadedLinkCount' => $loaded_link_count, 'linkCount' => $link_count]);
				},	
				'contentOptions' => function($model)
                    {					
						$color = 'white';
						if ($model->error_link_count > 0)
							$color = 'red';
						return ['style' => ['background' => $color, 'text-align' => 'center']];
                    },
					
				'options' => ['width' => '100px'],				
			],       
			
			
			[
				'attribute' => 'last_load',				
				'options' => ['width' => '130px'],	
				'contentOptions' => ['style' => ['text-align' => 'center']],						
			], 
			

            
			[
				'class' => 'yii\grid\ActionColumn', 
				'template' => '{links} {parse} {view} {update} {delete}',
				'buttons' =>
					[
						'links'=>  function ($url, $model, $key)
						{							
							return Html::a('<span class="glyphicon glyphicon-th-list"></span>', ['link/index', 'id_product' => $model->id], ['title' => Yii::t('app', 'Links')]);
						},

						'parse'=>  function ($url, $model, $key)
						{							
							return Html::a('<span class="glyphicon glyphicon-refresh"></span>', ['product/parse', 'id' => $model->id], ['title' => Yii::t('app', 'Parse Product')]);
						}
					],	
				'options' => ['width' => '105'],
			 
			
			],
        ],
    ]); ?>
</div>
