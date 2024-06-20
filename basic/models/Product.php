<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 *
 * @property Link[] $links
 */
class Product extends \yii\db\ActiveRecord
{
	
	
	public function getLast_load () 
	{
		$last_date = Link::find()->where (['id_product' => $this->id])->min('last_visit_date');
		if (empty ($last_date))
			return null;
						
		$last_date = strtotime($last_date);
		$now = strtotime(date("Y-m-d H:i:s"));	
		$s = ($now - $last_date);				
		$d = (int) ($s / (60 * 60 * 24));		
		$H = (int) ($s / (60 * 60));
		$i = (int) ($s / (60));		
		
		$out = '';						
		if ($d > 0) 
		{
			$out = $d . ' д.';
		}
		else
		{
			if ($H > 0) 
			{
				$out = $H . ' ч.';
			}
			else
			{
				
				if ($i > 0) 
				{
					$out = $i . ' мин.';
				}
				else					
				{
					if ($s > 0) 
					{
						$out = $s . ' сек.';
					}
				}
			}
		}
		return $out . ' назад';		
		
	}	
	
	public function getLink_count () 
	{
		return Link::find()->where (['id_product' => $this->id])->count();
	}
	
	public function getLoaded_link_count () 
	{
		return Link::find()->where (['id_product' => $this->id, 'loaded' => true])->count();
	}
	
	
	public function getError_link_count () 
	{
		return Link::find()->where (['id_product' => $this->id, 'loaded' => false])->count();
	}
	
	public function getMin_cost () 
	{
		return Link::find()->where (['id_product' => $this->id, 'main_link' => false])->min('cost');
	}
	
	public function getMax_cost () 
	{
		return Link::find()->where (['id_product' => $this->id, 'main_link' => false])->max('cost');
	}
	
	public function getMain_cost () 
	{
		return Link::find()->where (['id_product' => $this->id, 'main_link' => true])->max('cost');
	}
	
	public function SaveCostHistory () {
		$min_cost = $this->min_cost + 0;
		$max_cost = $this->max_cost + 0;
		$avg_cost = round(($min_cost + $max_cost) / 2);
		$now = date('Y-m-d');
		
		$product_cost = ProductCost::find()->where(['id_product' => $this->id, 'now' => $now])->one();
		if (empty($product_cost)) {
			$product_cost = new ProductCost();
			$product_cost->id_product = $this->id;
			$product_cost->now = $now;					
		}
		$product_cost->min_cost = $min_cost;
		$product_cost->max_cost = $max_cost;
		$product_cost->avg_cost = $avg_cost;
		$product_cost->save();	
	}
	
	public function getProductCostHistory ($now, $size) {
			
		$start = date('Y-m-d', strtotime($now . ' -' . ($size - 1) . ' day'));	
		$data = [];		
		for ($i = 0; $i < $size; $i ++) {
			$model = new ProductCost();
			$data[] = $model;
			$model->id_product = $this->id;
			$model->now = date('Y-m-d', strtotime($start . ' +' . $i . ' day'));		
			$model->min_cost = 0;
			$model->max_cost = 0;
			$model->avg_cost = 0;
			
			$product_cost = ProductCost::find()->andWhere(['id_product' => $this->id])->andWhere('now <= :now', [':now' => $model->now])->orderby(['now' => SORT_DESC])->limit(1)->one();
			if (!empty($product_cost)) {
				$model->min_cost = $product_cost->min_cost;
				$model->max_cost = $product_cost->max_cost;
				$model->avg_cost = $product_cost->avg_cost;			
			}						
		}		
		return $data;
	}
	
	public function getProductCostForecast ($now, $size, $forecast, $alpha = 0.6, $beta = 0.3) {			
						
		$dataset = $this->getProductCostHistory ($now, $size, $forecast);
		$forecastset = [];
		
		$fields = ['avg_cost', 'min_cost', 'max_cost'];	

		foreach ($fields as $field)
		{
		
			$a_ = null;
			$b_ = 0;
			$y_ = 0;
			$y = null;
			$k = 0;		
		
			foreach ($dataset as $data) 
			{
				$y = $data[$field];
				
				if (is_null($a_))
					$a_ = $y;		
				// Экспоненциально-сглаженный ряд
				$a = $alpha * $y + (1 - $alpha) * ($a_ + $b_);
				// Определяем значение тренда
				$b = $beta * ($a - $a_) + (1 - $beta) * $b_;						
			
				$a_ = $a;
				$b_ = $b;
				$y_ = $y;				
			}
		
			for ($i = 1; $i <= $forecast; $i ++) 
			{										
				if (!isset($forecastset[$i])) {
					$data = new ProductCost();		
					$data->now = date('Y-m-d', strtotime($now . ' +' . $i . ' day'));											
					$data->id_product = $this->id;
					$data->forecast = true;
					$forecastset[$i] = $data;
				}
				$data = $forecastset[$i];				
				$y = $a + $b * $i;	
				$data[$field] = round($y);					
			}
		}		
		return array_merge($dataset, $forecastset);
	}
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }
	
	

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),			
            'min_cost' => Yii::t('app', 'Min Cost'),
			'max_cost' => Yii::t('app', 'Max Cost'),
			'main_cost' => Yii::t('app', 'Main Cost'),
			'link_count' => Yii::t('app', 'Link Count'),
			'description' => Yii::t('app', 'Description'),
			'loaded_link_count' => Yii::t('app', 'Loaded Link Count'),
			'error_link_count' => Yii::t('app', 'Error Link Count'),
			'last_load' => Yii::t('app', 'Last Load'),
			
			
			
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinks()
    {
        return $this->hasMany(Link::className(), ['id_product' => 'id']);
    }
	
	public function getMainLink()
    {
        return $this->hasOne(Link::className(), ['id_product' => 'id'])->andWhere(['main_link' => true]);
    }
	
	public function getProductCosts()
    {
        return $this->hasMany(ProductCost::className(), ['id_product' => 'id']);
    }
}
