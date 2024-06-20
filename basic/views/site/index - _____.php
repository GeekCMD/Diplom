<?php



use yii\helpers\Html;

require __DIR__ . '/../../code/simplehtmldom_1_8_1/simple_html_dom.php';
require __DIR__ . '/../../code/phpQuery/phpQuery.php';



/* @var $this yii\web\View */
$this->title = Yii::$app->params['projectName'];

?>
<div class="site-index">

<?php

//echo phpinfo();
//$url = 'https://www.ozon.ru/context/detail/id/148225773/?utm_campaign=msk_kids_mp&utm_content=id_148225773%7Ccatid_7174&utm_medium=cpc&utm_source=cpc_yandex_market&ymclid=15486149925704563338800004';
$url = 'https://dastoys.ru/derevyannye-konstruktory/konstruktory-mechanical-wood/derevyannyy-konstruktor-vintovoy-gruzovik-samosval-194-detali/';
//$url = '';
//$url = 'https://dastoys.ru/shlemy/shlem-rytsarya-detskiy-vatslavka/';
//$url = 'https://toyterra.ru/catalog/derevyannyie-konstruktoryi-m-wood/konstruktor-3d-derevyannyiy-vintovoy-m-wood-gruzovik-samosval-art-mw-3003/?frommarket=http%3A%2F%2Fmarket.yandex.ru%2Fpartner&ymclid=15486150245883651326800002';
//$url = 'ze.khti.ru';
/*



function curl_get_contents($page_url, $base_url, $pause_time, $retry) {
    
   // $page_url - адрес страницы-источника
   // $base_url - адрес страницы для поля REFERER
   // $pause_time - пауза между попытками парсинга
   // $retry - 0 - не повторять запрос, 1 - повторить запрос при неудаче
   
    $error_page = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0");   	
    curl_setopt($ch, CURLOPT_COOKIEJAR, str_replace("\\", "/", getcwd()).'/gearbest.txt'); 
    curl_setopt($ch, CURLOPT_COOKIEFILE, str_replace("\\", "/", getcwd()).'/gearbest.txt'); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Автоматом идём по редиректам
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0); // Не проверять SSL сертификат
    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); // Не проверять Host SSL сертификата
    curl_setopt($ch, CURLOPT_URL, $page_url); // Куда отправляем
    curl_setopt($ch, CURLOPT_REFERER, $base_url); // Откуда пришли
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Возвращаем, но не выводим на экран результат
	curl_setopt ($ch , CURLOPT_TIMEOUT , 0 ) ;
    $response['html'] = curl_exec($ch);
    $info = curl_getinfo($ch);
    if($info['http_code'] != 200 && $info['http_code'] != 404) {
        $error_page[] = array(1, $page_url, $info['http_code']);
        if($retry) {
            sleep($pause_time);
            $response['html'] = curl_exec($ch);
            $info = curl_getinfo($ch);
            if($info['http_code'] != 200 && $info['http_code'] != 404)
                $error_page[] = array(2, $page_url, $info['http_code']);
        }
    }
    $response['code'] = $info['http_code'];
    $response['errors'] = $error_page;
    curl_close($ch);
    return $response;
 
}

*/
//print_r (curl_get_contents('https://dastoys.ru/derevyannye-konstruktory/konstruktory-mechanical-wood/derevyannyy-konstruktor-vintovoy-gruzovik-samosval-194-detali/', 'https://dastoys.ru', 10, false));
//print_r (curl_get_contents('https://www.ozon.ru', 'https://yandex.ru/search/?clid=9582&text=ozon&l10n=ru&lr=1095', 20, !true));
//print_r (curl_get_contents('https://www.ozon.ru/context/detail/id/148225773/?utm_campaign=msk_kids_mp&utm_content=id_148225773%7Ccatid_7174&utm_medium=cpc&utm_source=cpc_yandex_market&ymclid=15486149925704563338800004', 'https://www.ozon.ru', 10, false));

function file_get_contents_curl($url) {
	try {
		$ch = curl_init();
		if ($ch === false) {
			throw new Exception('failed to initialize');
		}
		try
		{
			curl_setopt($ch, CURLOPT_URL, $url);		
			curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//curl_setopt($ch, CURLOPT_SSLVERSION, 3);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);				
			curl_setopt($ch, CURLOPT_TIMEOUT, 0);
			curl_setopt($ch, CURLOPT_USERAGENT, "Opera/12.02 (Android 4.1; Linux; Opera Mobi/ADR-1111101157; U; en-US) Presto/2.9.201 Version/12.02");				
			$content = curl_exec($ch);		
			if ($content === false) {
				throw new Exception(curl_error($ch), curl_errno($ch));
			}		
			return $content;
		}
		finally
		{
			curl_close($ch);
		}		
	} 
	catch(Exception $e) 
	{
		trigger_error(sprintf('Curl failed with error #%d: %s', $e->getCode(), $e->getMessage()),  E_USER_ERROR);
	}
}
	
	
	// Кроме PHP_URL_HOST доступны еще PHP_URL_SCHEME, PHP_URL_PORT, PHP_URL_USER, PHP_URL_PASS, PHP_URL_PATH, PHP_URL_QUERY и PHP_URL_FRAGMENT.
	
	echo 'PHP_URL_HOST: ' . parse_url($url, PHP_URL_HOST) . '<br>';
	echo 'PHP_URL_SCHEME: ' . parse_url($url, PHP_URL_SCHEME) . '<br>';
	echo 'PHP_URL_PORT: ' . parse_url($url, PHP_URL_PORT) . '<br>';
	echo 'PHP_URL_USER: ' . parse_url($url, PHP_URL_USER) . '<br>';
	echo 'PHP_URL_PASS: ' . parse_url($url, PHP_URL_PASS) . '<br>';
	echo 'PHP_URL_PATH: ' . parse_url($url, PHP_URL_PATH) . '<br>';
	echo 'PHP_URL_QUERY: ' . parse_url($url, PHP_URL_QUERY) . '<br>';
	echo 'PHP_URL_FRAGMENT: ' . parse_url($url, PHP_URL_FRAGMENT) . '<br>';
	
	

	$html = file_get_contents_curl($url);
	//print_r (Html::Encode($html));




$pq = phpQuery::newDocument($html);
phpQuery::selectDocument($pq);

//print_r (Html::Encode($pq->htmlOuter()));


foreach(pq('span.price') as $e) { 	
	
	
	
	$tagName = $e->tagName; 	
	
	
	
	print_r ($e->parentNode->getAttribute('class') . ' ' . $e->getAttribute('class') . '<br>');	
	
	
	//if ($e->getAttribute('class') == 'added2cart') 
	{
		
		//print_r (Html::Encode($e->htmlOuter()));
		
		//foreach ($e->attributes as $a) {
		//		print_r ($a->name . ':' . $a->value . '<br>');
		//}	
		
		
	}
	
	
	//echo $tagName . ' ' . $e->className . '<br>' ;
	
	//print_r(Html::Encode($e->html()));
	//$childNodes = $li->childNodes; 
	// so you NEED to wrap it within phpQuery, using pq(); 
	//pq($li)->addClass('my-second-new-class'); 
}

*/
	
//print_r ('[' . Html::Encode($html) . ']');

$dom = str_get_html($html);
//price price_big

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


/*
// Find all images 
foreach($html->find('img') as $element) 
       echo $element->src . '<br>';

// Find all links 
foreach($html->find('a') as $element) 
       echo $element->href . '<br>';
*/

/*
$html = file_get_contents_curl($url);
$dom = new DOMDocument;
$dom->loadHTML($html);
$images = $dom->getElementsByTagName('img');


foreach ($images as $image) {
        echo $image->getAttribute('src') . '<br>';
}
*/



	

?>

</div>