<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ParserError */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parser Errors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parser-error-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>        
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
            'registration_date:datetime',
            [				
				'attribute' => 'url',						
				'format' => 'raw',								
				'contentOptions' => ['style' => ['word-break' => 'break-all']],
				'value' => Html::a($model->domain, ['site/redirect', 'url' => $model->url], ['target' => '_blank']),				
			],    
            'message:ntext',
			[				
				'attribute' => 'id_parser_rule',	
				'format' => 'raw',					
				'value' => empty ($model->parserRule) == false ? Html::a($model->parserRule->title, ['parser-rule/view', 'id' => $model->parserRule->id], ['target' => '_blank']) : null,				
			], 
			'loaded_value:ntext',											
        ],
    ]) ?>

</div>
