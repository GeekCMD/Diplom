<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ParserRule */
/* @var $form yii\widgets\ActiveForm */
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
                    url: "<?= Yii::$app->urlManager->createUrl (['parser-rule/test']); ?>",
                    data: $(parserRuleForm).serialize(),
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

<div class="parser-rule-form">

    <?php $form = ActiveForm::begin(['id' => 'parserRuleForm']); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'selector')->textInput(['maxlength' => true]) ?>

   

    <?= $form->field($model, 'test_url')->textarea(['rows' => 6]) ?>
	
	
	
	
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>	
	

    <?php ActiveForm::end(); ?>
	
	
	
	<textarea rows="6" id="testResult" class="form-control" readonly="true"></textarea>
	<br>
	
	<?= Html::a(Yii::t('app', 'Rule Test'), null, ['class' => 'btn btn-primary', 'onclick' => 'ruleTest();']) ?>		
		

</div>
