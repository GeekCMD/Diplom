<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LinkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Links');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => $product->title, 'url' => ['product/view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Link'), ['create', 'id_product' => $product->id], ['class' => 'btn btn-success']) ?>
		<?= Html::a(Yii::t('app', 'Parse Product'), ['product/parse', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
			[
				'attribute' => 'main_link',
				'format' => 'boolean',						
				'options' => ['width' => '100px'],				
			],  
			
			[
				'attribute' => 'url',	
				'format' => 'url',								
				'content' => function($data)
				{					
					return Html::a($data->domain, ['site/redirect', 'url' => $data->url], ['target' => '_blank']);
				},					
				//'options' => ['width' => '200px'],
				//'contentOptions' => ['style' => ['max-width' => '200px;', 'height' => '200px', 'word-break' => 'break-all']],
			],       
			
			
			
			[
				'attribute' => 'cost',						
				'options' => ['width' => '100px'],	
				'content' => function($data)
				{		
					/*
					$variation = $data->variation;
					if (!is_null ($variation))
						$variation = ' (' . (($variation > 0) ? '+' : '') . '' . $variation . ')';					
					return  $data->cost . $variation;
					*/
					return  $data->cost;
				},	
				
			],       
			
			[
				'attribute' => 'variation',	
				//'format' => 'ntext',		
				'content' => function($data)
				{		
					if (is_null($data->cost))
						return null;
					$variation = $data->variation;
					if (is_null ($variation))
						return null;
					return  (($variation > 0) ? '+' : '') . ' ' . $variation;
				},	
				'contentOptions' => ['style'=>'text-align: right;'],				
				'options' => ['width' => '100px'],				
			],       
			            
			
			[
				'attribute' => 'last_visit_date',
				'format' => 'datetime',						
				'options' => ['width' => '130px'],				
			], 
			
			[
				'attribute' => 'loaded',
				'format' => 'boolean',						
				'options' => ['width' => '100px'],				
			], 
			
			[
				'class' => 'yii\grid\ActionColumn', 
				'template' => '{setup-as-main-link} {parse} {view} {update} {delete}',
				'buttons' =>
					[
						'parse'=>  function ($url, $model, $key)
						{							
							return Html::a('<span class="glyphicon glyphicon-refresh"></span>', ['link/parse', 'id' => $model->id], ['title' => Yii::t('app', 'Parse Link')]);
						}
						,
						'setup-as-main-link'=>  function ($url, $model, $key)
						{							
							return Html::a('<span class="glyphicon glyphicon-flag"></span>', ['link/setup-as-main-link', 'id' => $model->id], ['title' => Yii::t('app', 'Setup As Main Link')]);
						}
					],	
				'options' => ['width' => '105'],
			 
			
			],
        ],
    ]); ?>
</div>
