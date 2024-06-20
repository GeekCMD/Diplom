<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
	const STATUS_REGISTRED = 1;
	
	const USER_TYPE_ADMIN = 1;
	const USER_TYPE_USER = 2;		
	const USER_TYPE_STUDENT = 3;		
	
	
	public $password_change = "";			
	public $password_old = "";		
	public $password_new = "";		
	public $password_confirmation = "";	
	public $stored_password;
		
			
	
	
	public function getIsAdmin ()
	{
		return $this->id_user_type == self::USER_TYPE_ADMIN;		
	}
	
	public function getIsUser ()
	{
		return $this->id_user_type == self::USER_TYPE_USER;		
	}			
	
	public function getIsStudent ()
	{
		return $this->id_user_type == self::USER_TYPE_STUDENT;		
	}	
	
		
	public function getTitle ()
	{
		return $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name /*. ', т.:' . $this->phone*/;		
	}
	
	public function getTitle_long ()
	{
		return $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name . ', т.:' . $this->phone;		
	}
	
	public function getTitle_short ()
	{
		return $this->last_name . ' ' . substr($this->first_name, 0, 2) . '. ' . substr($this->middle_name, 0, 2) . '.';		
	}
	
	public function attributeLabels()
    {
        return [         
			'user_type' => Yii::t('app', 'User Type'),
			'id_user_type' => Yii::t('app', 'User Type'),
			'status' => Yii::t('app', 'Status'),
            'username' => Yii::t('app', 'Username'),					
            'id' => Yii::t('app', 'ID'),				
			'last_name'=> Yii::t('app', 'Last Name'),
			'first_name'=> Yii::t('app', 'First Name'),
			'middle_name'=> Yii::t('app', 'Middle Name'),					
			'phone'=> Yii::t('app', 'Phone'),					
			'nikname'=> Yii::t('app', 'Nikname'),		
			'created_at' => Yii::t('app', 'Created At'),	
			'updated_at' => Yii::t('app', 'Updated At'),			
			'password' => Yii::t('app', 'Password'),						
			'password_old' => Yii::t('app', 'Old Password'),
			'password_new' => Yii::t('app', 'New Password'),
			'password_confirmation' => Yii::t('app', 'Password Confirmation'),				
			'birthday'=> Yii::t('app', 'Birthday'),		
			'phone'=>Yii::t('app', 'Phone'),
			
			
			
        ];
    }
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_REGISTRED],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_REGISTRED]],
			
			['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => Yii::t('app', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],
						
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => Yii::t('app', 'This email address has already been taken.')],
						
						
            [['password_new', 'password_confirmation'], 'string', 'min' => 6],			
			[['first_name', 'middle_name', 'last_name', 'nikname', 'password_str', 'phone'], 'string', 'max' => 255],						
			[['id_user_type'], 'integer'],	
			
						
			
			[['password_new', 'password_confirmation'], 'required', 'on' => 'create'],
			
			
        ];
    }
	
	/*
	public function scenarios()
    {
        return [
            'create' => ['password_new', 'password_confirmation'],
            'update' => ['username', 'email', 'password'],
        ];
    }
	*/

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

	
	public function getPassword()
    {
        return '';
    }
	
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
		$this->password_str = $password;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
	
	
	public function generateActivationToken()
    {
        $this->activation_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
	
	
    public function removeActivationToken()
    {
        $this->activation_token = null;
    }
	
	public static function findByActivationToken($token)
    {
        
		if (!static::isActivationTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'activation_token' => $token,
            'status' => self::STATUS_REGISTRED,
        ]);
    }

    public static function isActivationTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.activationTokenExpire'];
        return $timestamp + $expire >= time();
    }

    
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUserType()
    {
        return $this->hasOne(UserType::className(), ['id' => 'id_user_type']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDiscount()
    {
        return $this->hasOne(Discount::className(), ['id' => 'id_discount']);
    }
	
		
	
}
