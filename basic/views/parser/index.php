<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
?>


<div class="parser-index">

<h1>parser/index</h1>

<?php


require_once Yii::$app->getBasePath() . '\code\phpQuery\phpQuery.php';


print_r (Yii::$app->getBasePath());

print_r (Yii::$app->getBaseUrl());
exit();
$html = '<div><span class="c123">777</span></div>';
$doc = phpQuery::newDocument($html);
phpQuery::selectDocument($doc);
//print_r (Html::Encode($pq->htmlOuter()));


foreach(pq('span') as $e) { 
	//$tagName = $e->tagName; 		
	print_r ($e->parentNode->parentNode->parentNode->getAttribute('class') . ' ' . $e->getAttribute('class') . '<br>');	
}



require __DIR__ . '/../../code/simplehtmldom_1_8_1/simple_html_dom.php';
require __DIR__ . '/../../code/phpQuery/phpQuery.php';


//$url = 'https://www.ozon.ru/context/detail/id/148225773/?utm_campaign=msk_kids_mp&utm_content=id_148225773%7Ccatid_7174&utm_medium=cpc&utm_source=cpc_yandex_market&ymclid=15486149925704563338800004';
$url = 'https://dastoys.ru/derevyannye-konstruktory/konstruktory-mechanical-wood/derevyannyy-konstruktor-vintovoy-gruzovik-samosval-194-detali/';
//$url = '';
//$url = 'https://dastoys.ru/shlemy/shlem-rytsarya-detskiy-vatslavka/';
//$url = 'https://toyterra.ru/catalog/derevyannyie-konstruktoryi-m-wood/konstruktor-3d-derevyannyiy-vintovoy-m-wood-gruzovik-samosval-art-mw-3003/?frommarket=http%3A%2F%2Fmarket.yandex.ru%2Fpartner&ymclid=15486150245883651326800002';
//$url = 'ze.khti.ru';


	
	
	
	
	

$html = file_get_contents_curl($url);
//print_r (Html::Encode($html));







	


$dom = str_get_html($html);

foreach($dom->find('div > span.price') as $element) {
	$class = $element->getAttribute('class');	
	echo '<br>';
	echo $class . ': ';
	print_r ($element->getAllAttributes ());
	echo '<br>';
	print_r ($element->innertext);
	echo '<br>';
	/*
	if (!empty($element->getAttribute('data-price'))) {
		//if ($element->class == 'price price_big') 
		{
			print_r ($element->getAllAttributes ());
			//echo $class . ': ' . $element->innertext . ' ' . $element->getAttribute('data-price') . '<br>';
		}
	}
	*/
}

?>

</div>


<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
