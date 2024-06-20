<?php

namespace app\code;

use Yii;
use yii\base\UserException;

require_once Yii::$app->getBasePath() . '/code/phpQuery/phpQuery.php';

/**
* Класс, реализующий функции парсера
*
*/
class Parser
{  	
	/**
     * Метод загрузки HTML выбранной страницы     
     * @return HTML запрашиваемой страницы
     */
	public static function getHtml($url) {
		//try 
		{
			$ch = curl_init();
			if ($ch === false) {
				throw new Exception('Failed curl to initialize');
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
					throw new UserException (curl_error($ch), curl_errno($ch));
				}		
				return $content;
			}
			finally
			{
				curl_close($ch);
			}		
		} 
		//catch(Exception $e) 
		{
			//trigger_error(sprintf('Curl failed with error #%d: %s', $e->getCode(), $e->getMessage()),  E_USER_ERROR);
		}
	}
	
	public static function getText (&$html, $selector) {
		$doc = \phpQuery::newDocument($html);
		try
		{
			\phpQuery::selectDocument($doc);				
			return pq($selector)->text();
		}
		finally
		{
			unset ($doc);
		}		
	}
	
	public static function getCost ($text) {
		$value = $text;									
		$value = preg_replace("/[^,.0-9]/", '', $value);
		$value = trim($value);
		return $value;		
	}
}