<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ParserRule */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parser Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<script>


    function ruleTest() {
        //var retVal = confirm("Проверить правило?");
        //if (retVal == true) 
		{
			$out = document.getElementById('testResult');
			
			$out.value = "<?= Yii::t('app', 'Rule Test Execution') ?>";
            $.ajax(
                {
                    type: "POST",
                    url: "<?= Yii::$app->urlManager->createUrl (['parser-rule/test', 'id' => $model->id]); ?>",
                    //data: $(parserRuleForm).serialize(),
                    success: function (result) {
                        if (result.Error) 
						{							
							$out.value = result.Error;
                        }
						else 
						{   						
							$out.value = result.trim();
                        }
                    }
                });

            return true;
        } 
		//else {return false;}
    }
</script>

<div class="parser-rule-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<?= Html::a(Yii::t('app', 'Create Parser Rule'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            [				
				'attribute' => 'url',						
				'format' => 'raw',								
				'contentOptions' => ['style' => ['word-break' => 'break-all']],
				'value' => Html::a($model->url, ['site/redirect', 'url' => $model->url], ['target' => '_blank']),				
			], 
            'selector',
            //'attribute',
            //'test_url:ntext',
        ],
    ]) ?>
	
	<textarea rows="6" id="testResult" class="form-control" readonly="true"></textarea>
	<br>
	
	<?= Html::a(Yii::t('app', 'Rule Test'), null, ['class' => 'btn btn-primary', 'onclick' => 'ruleTest();']) ?>

</div>
