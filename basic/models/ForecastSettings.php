<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password_str
 * @property string $password_hash
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $activation_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $nikname
 * @property int $id_user_type
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $phone
 * @property double $forecast_alpha
 * @property double $forecast_beta
 * @property int $forecast_data_size
 * @property int $forecast_size
 *
 * @property UserType $userType
 */
class ForecastSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['forecast_data_size', 'forecast_size', 'forecast_alpha', 'forecast_beta'], 'required'],
            [['forecast_data_size'], 'integer', 'min' => 1],
			[['forecast_size'], 'integer', 'min' => 0],
            [['forecast_alpha', 'forecast_beta'], 'number', 'min' => 0, 'max' => 1],            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [            
            'forecast_alpha' => Yii::t('app', 'Forecast Alpha'),
            'forecast_beta' => Yii::t('app', 'Forecast Beta'),
            'forecast_data_size' => Yii::t('app', 'Forecast Data Size'),
            'forecast_size' => Yii::t('app', 'Forecast Size'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserType()
    {
        return $this->hasOne(UserType::className(), ['id' => 'id_user_type']);
    }
}
