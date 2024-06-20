<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

//raoul2000\bootswatch\BootswatchAsset::$theme = 'cerulean'; //+
//raoul2000\bootswatch\BootswatchAsset::$theme = 'cosmo';
//raoul2000\bootswatch\BootswatchAsset::$theme = 'custom';
//raoul2000\bootswatch\BootswatchAsset::$theme = 'cyborg';
//raoul2000\bootswatch\BootswatchAsset::$theme = 'darkly';
//raoul2000\bootswatch\BootswatchAsset::$theme = 'default';
//raoul2000\bootswatch\BootswatchAsset::$theme = 'flatly';//+
//raoul2000\bootswatch\BootswatchAsset::$theme = 'journal'; //+
//raoul2000\bootswatch\BootswatchAsset::$theme = 'lumen';
//raoul2000\bootswatch\BootswatchAsset::$theme = 'paper'; // +++
//raoul2000\bootswatch\BootswatchAsset::$theme = 'readable'; //+
//raoul2000\bootswatch\BootswatchAsset::$theme = 'sandstone'; // +
//raoul2000\bootswatch\BootswatchAsset::$theme = 'simplex'; // +
//raoul2000\bootswatch\BootswatchAsset::$theme = 'slate';
//raoul2000\bootswatch\BootswatchAsset::$theme = 'spacelab';
//raoul2000\bootswatch\BootswatchAsset::$theme = 'superhero';
//raoul2000\bootswatch\BootswatchAsset::$theme = 'united';
//raoul2000\bootswatch\BootswatchAsset::$theme = 'yeti';

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->params['projectName'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
	
	$items = [];
	
	//$items[] = ['label' => Yii::t('app', 'Houses'), 'url' => ['/house/index']];			
		
	if (empty(Yii::$app->user->identity) == false)
	{	
		
		
		$menu = [];			
		
		//$items[] = ['label' => Yii::t('app', 'Tester'), 'url' => ['/tester/index']];
		//$items[] = ['label' => Yii::t('app', 'Results'), 'url' => ['/result/index']];	
		if (Yii::$app->user->identity->IsAdmin || Yii::$app->user->identity->IsUser) {			
			//$items[] = ['label' => Yii::t('app', 'Tests'), 'url' => ['/test/index']];
		}
		$items[] = ['label' => Yii::t('app', 'Products'), 'url' => ['/product/index']];								
		
		
		$menu = [];
		$menu[] = ['label' => Yii::t('app', 'Parser Rules'), 'url' => ['/parser-rule/index']];				
		$menu[] = ['label' => Yii::t('app', 'Parser Errors'), 'url' => ['/parser-error/index']];				
		$menu[] = ['label' => Yii::t('app', 'Forecast Settings'), 'url' => ['/forecast-settings/view']];						
		//$menu[] = ['label' => Yii::t('app', 'Parser'), 'url' => ['/parser/index']];				
		$menu[] = ['label' => Yii::t('app', 'Users'), 'url' => ['/user/index']];		
		
		
		$items[] = ['label' => Yii::t('app', 'Modules'), 'items'=>$menu];	
		
			
		/*
		if (Yii::$app->user->identity->IsAdmin)
		{			
			
		}
		*/
		

		$menu = [];						
		$menu[] = ['label' => Yii::t('app', 'User Data'), 'url' => ['user/view', 'id' => Yii::$app->user->identity->id]];			
		$menu[] = [ 'label' => Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];			
		$items[] = ['label' => Yii::$app->user->identity->username, 'items'=>$menu];					
		
	}
	else
	{
		//$items[] = ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']];
		//$items[] = ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']];	
		$items[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
	}
	
	
	
	
	
	
	
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items
    ]);
    NavBar::end();
    ?>
	
	<br>

    <div class="container">
		<?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
		<?php
	
			foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
				echo '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message . '</div>';
			}
		?>
        
        <?= $content ?>
    </div>
	
	
	
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->params['companyName'] ?> <?= date('Y') ?></p>
        <p class="pull-right">
		</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
