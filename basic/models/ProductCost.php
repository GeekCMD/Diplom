<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_cost".
 *
 * @property int $id_product
 * @property string $now
 * @property double $min_cost
 * @property double $cost
 * @property double $max_cost
 *
 * @property Product $product
 */
class ProductCost extends \yii\db\ActiveRecord
{
	
	public $forecast;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_cost';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_product', 'now'], 'required'],
            [['id_product'], 'integer'],
            [['now'], 'safe'],
            [['min_cost', 'avg_cost', 'max_cost'], 'number'],
            [['id_product', 'now'], 'unique', 'targetAttribute' => ['id_product', 'now']],
            [['id_product'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['id_product' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_product' => Yii::t('app', 'Id Product'),
            'now' => Yii::t('app', 'Now'),
            'min_cost' => Yii::t('app', 'Min Cost'),
            'avg_cost' => Yii::t('app', 'Avg Cost'),
            'max_cost' => Yii::t('app', 'Max Cost'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'id_product']);
    }
}
