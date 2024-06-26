<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Link */

$this->title = Yii::t('app', 'Create Link');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => $product->title, 'url' => ['product/view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Links'), 'url' => ['index', 'id_product' => $product->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
