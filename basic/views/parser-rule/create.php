 <?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ParserRule */

$this->title = Yii::t('app', 'Create Parser Rule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parser Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parser-rule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
