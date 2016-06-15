<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;

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
            //all field safe
			[['id_order', 'company_name', 'loading_date', 'unload_date', 'location', 'price', 'tax', 'note', 'photo'], 'safe'],
			[['id_order',], 'integer'],
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
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
	
	/**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        /*$query->andFilterWhere([
            'id_order' => $this->id_order,
            'loading_date' => $this->loading_date,
            'unload_date' => $this->unload_date,
            'price' => $this->price,
        ]);*/

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
			->andFilterWhere(['like', 'loading_date', $this->loading_date])
			->andFilterWhere(['like', 'unload_date', $this->unload_date])
			->andFilterWhere(['like', 'location', $this->location])
			->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
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
