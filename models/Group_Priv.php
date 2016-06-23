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
class Group_Priv extends ActiveRecord
{    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            //all field safe
			/*[['id_order', 'company_name', 'loading_date', 'unload_date', 'location', 'price', 'tax', 'note', 'photo'], 'safe'],
			[['id_order',], 'integer'],*/
        ];
    }

	/**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'group_priv';
    }
    
	/* Invoice Header Model attribute labels */
	public function attributeLabels() {
		/*return [
			'company_name' => Yii::t('app', 'Company Name'),
			'loading_date' => Yii::t('app', 'Loading Date'),
			'unload_date' => Yii::t('app', 'Unloading Date'),
			'location' => Yii::t('app', 'Location'),
			'price' => Yii::t('app', 'Price'),
			'note' => Yii::t('app', 'Note'),
			'photo' => Yii::t('app', 'Photo'),
		];*/
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
     * Finds priv by [[group_priv]]
     *
     * @return array of access_priv
     */
    public function getPriv($group_id, $module_id)
    {
		$data = group_priv::find()
				->select('access_priv')
				->where('group_id ="'.$group_id. '" AND module_id ="' .$module_id. '"')
				->one();
	
		if(count($data) > 0) 
			$access_priv = explode(',',$data->access_priv);
		else
			$access_priv = 0;
		
        return $access_priv;
    }
}
