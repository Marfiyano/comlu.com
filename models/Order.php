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
            // id_order is required
            [['id_order'], 'required'],
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
			'company_name' => Yii::t('app', 'Nama Perusahaan'),
			'loading_date' => Yii::t('app', 'Tanggal Loading'),
			'unload_date' => Yii::t('app', 'Tanggal Unload'),
			'location' => Yii::t('app', 'Lokasi'),
			'price' => Yii::t('app', 'Harga'),
			'note' => Yii::t('app', 'Catatan'),
			'photo' => Yii::t('app', 'Foto'),
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
