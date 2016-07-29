<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;

//class User extends \yii\base\Object implements \yii\web\IdentityInterface
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    //public $id;
	//public $group_user;
    //public $username;
    //public $password;
    //public $authKey;
    //public $accessToken;

	/**
     * @return array the validation rules.
     */
    public function rules()
    {
        /*return [
            //all field safe
			[['id_order', 'company_name', 'loading_date', 'unload_date', 'location', 'price', 'tax', 'note', 'photo'], 'safe'],
			[['id_order',], 'integer'],
        ];*/
    }

	/**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'user';
    }
	
    /*private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];*/


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
		//bawaan Yii2
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
		
		$user = User::findOne($id);

        if(count($user)){
            return new static($user);
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //bawaan Yii2
		/*foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;*/
		
        /*$user = User::find()->where(['accessToken'=>$token])->one();
        if(count($user)){
            return new static($user);
        }
        return null;*/
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
		//bawaan Yii2
        /*foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;*/
		
		$user = User::find()->where(['username'=>$username])->one();
		
        if(count($user)){
            return new static($user);
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {	
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === MD5($password);
    }
	
}
