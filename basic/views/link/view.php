<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Link */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => $product->title, 'url' => ['product/view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Links'), 'url' => ['index', 'id_product' => $product->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<?= Html::a(Yii::t('app', 'Create Link'), ['create', 'id_product' => $product->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
	<p>
		<?= Html::a(Yii::t('app', 'Parse Link'), ['parse', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a(Yii::t('app', 'Setup As Main Link'), ['link/setup-as-main-link', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p> 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'id_product',
            'position',            
			[				
				'attribute' => 'url',						
				'format' => 'raw',								
				'contentOptions' => ['style' => ['word-break' => 'break-all']],
				'value' => Html::a($model->domain, ['site/redirect', 'url' => $model->url], ['target' => '_blank']),				
			],    
			'main_link:boolean',
            'cost',
			
			[				
				'attribute' => 'variation',		
				'contentOptions' => ['style' => ['word-break' => 'break-all']],
				//'value' => Html::a($model->domain, $model->url, ['target' => '_blank']),
				'content' => function($data)
					{		
						if (is_null($data->cost))
							return null;
						$variation = $data->variation;
						if (is_null ($variation))
							return null;
						return  (($variation > 0) ? '+' : '') . ' ' . $variation;
					},					
			],   
			
			
			
            'last_visit_date:datetime',
        ],
    ]) ?>

</div>
