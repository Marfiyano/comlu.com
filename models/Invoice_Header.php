<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Invoice_Header is represent Invoice_Header Table.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Invoice_Header extends ActiveRecord
{    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // invoice_number is required
            [['invoice_number'], 'required'],
            // rememberMe must be a boolean value
        ];
    }

	/**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'Invoice_Header';
    }
    
	/* Invoice Header Model attribute labels */
	public function attributeLabels() {
		return [
			'invoice_number' => Yii::t('app', 'Invoice Number'),
			'total' => Yii::t('app', 'Total'),
			'create_date' => Yii::t('app', 'Create Date'),
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
