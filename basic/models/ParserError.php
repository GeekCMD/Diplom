<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parser_error".
 *
 * @property int $id
 * @property string $registration_date
 * @property string $url
 * @property string $message
 * @property int $id_parser_rule
 * @property string $loaded_value
 *
 * @property ParserRule $parserRule
 */
class ParserError extends \yii\db\ActiveRecord
{
	
	public function getDomain () {
		
		return parse_url($this->url, PHP_URL_HOST);
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
        return 'parser_error';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['registration_date'], 'safe'],
            [['url', 'message', 'loaded_value'], 'string'],
            [['id_parser_rule'], 'integer'],
            [['id_parser_rule'], 'exist', 'skipOnError' => true, 'targetClass' => ParserRule::className(), 'targetAttribute' => ['id_parser_rule' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'registration_date' => Yii::t('app', 'Registration Date'),
            'url' => Yii::t('app', 'Url'),
            'message' => Yii::t('app', 'Message'),
            'id_parser_rule' => Yii::t('app', 'Id Parser Rule'),
            'loaded_value' => Yii::t('app', 'Loaded Value'),		
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParserRule()
    {
        return $this->hasOne(ParserRule::className(), ['id' => 'id_parser_rule']);
    }
}
