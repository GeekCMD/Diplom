<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ForecastSettings */

$this->title = Yii::t('app', 'Forecast Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forecast-settings-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update'], ['class' => 'btn btn-primary']) ?>        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [      
			'forecast_data_size',
            'forecast_size',
            'forecast_alpha',
            'forecast_beta',
            
        ],
    ]) ?>

</div>
