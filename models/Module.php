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
class Module extends ActiveRecord
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
        return 'module';
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
    public function getModule($module_name='')
    {
		$data = Module::find()
				->where(($module_name != "" ? 'module_name = "'.$module_name.'" AND ' : "").'menu ="1"')
				->orderBy('order')
				->all();
		
        return $data;
    }
}
