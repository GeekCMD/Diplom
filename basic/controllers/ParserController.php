<?php

namespace app\controllers;

use Yii;
use app\models\Link;
use app\models\Product;
use app\models\ParserRule;
use app\models\ParserError;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\UserException;

use app\code\Parser;

set_time_limit (3600);

class ParserController extends \yii\web\Controller
{
	
	public function behaviors()
    {	
        return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => 
				[	
					[
						'actions' => ['index', 'parse-product', 'parse-link'],
						'allow' => true,
						'roles' => ['@'],																	
					],					
				],
			],			
        ];
    }
	
    public function actionIndex()
    {
				
        return $this->render('index');
    }
	
	public static function WriteError ($url, $message, $id_parser_rule = null, $loaded_value = null) {
		$model = new ParserError();
		$model->registration_date = date("Y-m-d H:i:s");
		$model->url = $url;		
		$model->message = $message;
		$model->id_parser_rule = $id_parser_rule;
		$model->loaded_value = $loaded_value;
		$model->save();		
	}
	
	
	public static function ParseProductAll () {		
		$error_count = 0;
		$products = Product::find()->all();		
		foreach ($products as $product) 
		{
			$error_count += ParserController::ParseProduct($product->id);				
		}
		return $error_count;
	}		
	
	public static function ParseProduct ($id_product) {		
		$product = ProductController::findModel ($id_product);
		$product_links = $product->links;
		$error_count = 0;
		foreach ($product_links as $link) {
			if (ParserController::ParseLink($link->id) == false) 
			{
				$error_count += 1;			
			}
		}		
		return $error_count;
	}	

	public static function ParseLink ($id_link) {
		
		$link = LinkController::findModel ($id_link);		
		try		
		{
			$rule = ParserRule::getUrlRule ($link->url);			
			if (empty ($rule)) 
			{
				ParserController::WriteError ($link->url, Yii::t('app', 'Rule not defined'));
				return false;
			}				
			try
			{		
				try
				{
					$link->last_visit_date = date("Y-m-d H:i:s");
					$link->cost = null;					
					$link->loaded = false;
					try
					{
						$html = Parser::getHtml($link->url);								
					}
					catch (UserException $e) 
					{	
						ParserController::WriteError ($link->url, Yii::t('app', 'Curl failed with error #{errorCode} : {errorMessage}', ['errorCode' => $e->getCode(), 'errorMessage' => $e->getMessage()]), $rule->id);						
						return false;
					}					
					
					if (empty ($html))
					{
						ParserController::WriteError ($link->url, Yii::t('app', 'Html not loaded'), $rule->id);
						return false;
					}		
					$value = Parser::getText ($html, $rule->selector);									
					$value = Parser::getCost ($value);									
					if (empty ($value) || strlen($value) > 25) {
						if (empty ($value))
							$value = null;
						ParserController::WriteError ($link->url, Yii::t('app', 'Value is empty'), $rule->id, $value);
						return false;
					}
					$link->cost = $value + 0;				
					$link->loaded = true;
				}
				finally
				{
					$link->save();
				}
			}
			finally
			{
				unset($rule);
			}
			$link->product->SaveCostHistory();
		}
		finally
		{
			unset($link);
		}		
		return true;
	}	
	
}
