<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "link".
 *
 * @property int $id
 * @property int $id_product
 * @property int $position
 * @property string $url
 * @property double $cost
 * @property string $last_visit_date
 *
 * @property Product $product
 * @property LinkHistory[] $linkHistories
 */
class Link extends \yii\db\ActiveRecord
{
	
	public function afterSave($insert, $changedAttributes){
		
		parent::afterSave($insert, $changedAttributes);	
		
		$product = $this->product;
		if (!empty($product)) {
			$product_links = $product->links;	
			if ($this->main_link) {						
				foreach ($product_links as $product_link) {
					if ($product_link->main_link && $product_link->id != $this->id) {
						$product_link->main_link = false;
						$product_link->save();
					}
				}
			} 		
			else
			{
				if (count($product_links) == 1 && !$this->main_link) {								
					$this->main_link = true;
					$this->save();					
				}
			}			
		}
	}
	
	public function beforeDelete()
	{        
		if ($this->main_link) {
			$product = $this->product;
			if (!empty($product)) {			
				$link = Link::find()->andWhere(['id_product' => $product->id])->andWhere(['<>','id', $this->id])->orderby(['position' => SORT_ASC])->one();
				if (!empty($link)) {
					$link->SetupAsMainLink ();
				}	
			}		
		}
		return parent::beforeDelete();
	}
		
	
	public function SetupAsMainLink () {		
		if ($this->main_link) {
			return;
		}
		$product_links = $this->product->links;		
		foreach ($product_links as $product_link) {
			if ($product_link->main_link && $product_link->id != $this->id) {
				$product_link->main_link = false;
				$product_link->save();
			}
		}
		$this->main_link = true;
		$this->save();
	}
	
	
	public function getDomain () {
		
		return parse_url($this->url, PHP_URL_HOST);
	}
	
	public function getVariation () {
		$product = $this->product;
		if (!empty($product)) {
			$main_link = $product->mainLink;
			
			if ($main_link->id == $this->id) 
				return null;
			
			if (!empty ($main_link)) {
				return $this->cost - $main_link->cost;
			}
		}
		return null;
	}
	
	
	public function getTitle () {
		return $this->domain;
		/*
		$max_size = 25;	
		if (strlen($this->url) > $max_size)		
			return substr($this->url, 0, $max_size) . ' ...';
		return $this->url;
		*/
	}
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['main_link', 'loaded'], 'boolean'],
            [['id_product', 'position'], 'integer'],
            [['url'], 'string'],
            [['cost'], 'number'],
            [['last_visit_date'], 'safe'],
            [['id_product'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['id_product' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_product' => Yii::t('app', 'Id Product'),
            'position' => Yii::t('app', 'Position'),
            'url' => Yii::t('app', 'Url'),
            'cost' => Yii::t('app', 'Cost'),
            'last_visit_date' => Yii::t('app', 'Last Visit Date'),
			'main_link' => Yii::t('app', 'Main Link'),
			'variation' => Yii::t('app', 'Variation'),
			'loaded' => Yii::t('app', 'Loaded'),
			
			
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'id_product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinkHistories()
    {
        return $this->hasMany(LinkHistory::className(), ['id_link' => 'id']);
    }
}
