<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parser_rule".
 *
 * @property int $id
 * @property string $url
 * @property string $selector
 * @property string $attribute
 * @property string $test_url
 */
class ParserRule extends \yii\db\ActiveRecord
{
	
	public static function getUrlRule ($url) {		
		$rule = ParserRule::find()->where (':url like concat("%",  url, "%")', [':url' => $url])->orderby(['url' => SORT_ASC])->limit(1)->one();		
		return $rule;
	}	
	
	public function getTitle () {
		return $this->url;
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parser_rule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['test_url'], 'string'],
            [['url', 'selector'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Url'),
            'selector' => Yii::t('app', 'Selector'),
            
            'test_url' => Yii::t('app', 'Test Url'),
        ];
    }
}
