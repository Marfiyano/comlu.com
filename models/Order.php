<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Order is represent Order Table.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Order extends ActiveRecord
{    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // company_name, loading_date, unload_date, location, price is required
	    [['company_name','loading_date','unload_date','location','price'], 'required'],
	    // id_order, note, photo is required
	    [['id_order','note','photo'], 'safe'],
            // rememberMe must be a boolean value
        ];
    }

	/**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'Order';
    }
    
	/* Invoice Header Model attribute labels */
	public function attributeLabels() {
		return [
			'company_name' => Yii::t('app', 'Company Name'),
			'loading_date' => Yii::t('app', 'Loading Date'),
			'unload_date' => Yii::t('app', 'Unloading Date'),
			'location' => Yii::t('app', 'Location'),
			'price' => Yii::t('app', 'Price'),
			'note' => Yii::t('app', 'Note'),
			'photo' => Yii::t('app', 'Photo'),
		];
	}

	/**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
