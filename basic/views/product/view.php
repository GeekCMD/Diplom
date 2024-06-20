<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a(Yii::t('app', 'Parse Product'), ['product/parse', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a(Yii::t('app', 'Links'), ['link/index', 'id_product' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'title',
			'min_cost',
			'max_cost',
			'main_cost',			
			'link_count',
			'loaded_link_count',
			'error_link_count',
			'last_load',	
            'description:ntext',
        ],
    ]) ?>
	
	<?php 
				$data = $forecast_dataset;
				
				$categories = [];
				$avg_cost = [];
				$max_cost = [];
				$min_cost = [];
				$forecast = [];
				$forecast_start = null;
				$data_length = count ($data);
				
				for ($i = 0; $i < count ($data); $i ++)
				{
					$categories[] = \Yii::$app->formatter->asDate($data[$i]['now']);
					$avg_cost[] = $data[$i]['avg_cost'] + 0;
					$max_cost[] = $data[$i]['max_cost'] + 0;
					$min_cost[] = $data[$i]['min_cost'] + 0;
					//$forecast[] =  $data[$i]['forecast'] + 0;
					if (is_null($forecast_start)) {
						if ($data[$i]->forecast)
							$forecast_start = $i - 1;
					}
						 
					
					
				}
				
				echo Highcharts::widget([
					'options' => [
						'title' => ['text' => Yii::t('app', 'Price change')],
						'xAxis' => [
							'categories' => $categories
						],
						'yAxis' => [
							'title' => ['text' => Yii::t('app', 'Cost')]
						],
						'series' => [
						
							[
								'name' => Yii::t('app', 'Min Cost'), 
								'visible' => false,
								'data' => $min_cost,
								'zoneAxis' => 'x',
								'zones' => [
									[
										'value' => $forecast_start, 
										'dashStyle' => 'solid',
									],
									[
										'value' => $forecast_start + $data_length, 
										'dashStyle' => 'dot',
									],
									
								],
							],
						
							[
								'name' => Yii::t('app', 'Avg Cost'), 
								'data' => $avg_cost,								
								'zoneAxis' => 'x',
								'zones' => [
									[
										'value' => $forecast_start, 
										'dashStyle' => 'solid',
									],
									[
										'value' => $forecast_start + $data_length, 
										'dashStyle' => 'dot',
									],
									
								],
							 
							],
							 
							
							[
								'name' => Yii::t('app', 'Max Cost'), 
								'visible' => false,
								'data' => $max_cost,
								'zoneAxis' => 'x',
								'zones' => [
									[
										'value' => $forecast_start, 
										'dashStyle' => 'solid',
									],
									[
										'value' => $forecast_start + $data_length, 
										'dashStyle' => 'dot',
									],
									
								],
							],
							//['name' => Yii::t('app', 'Forecast'), 'data' => $forecast],
						], 
						
					]
				]);
			?>
			
		<?= Html::a(Yii::t('app', 'Forecast Settings'), ['forecast-settings/update'], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>

</div>
