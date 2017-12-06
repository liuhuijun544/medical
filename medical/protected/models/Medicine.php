<?php

/**
 * This is the model class for table "medicine".
 *
 * The followings are the available columns in table 'medicine':
 * @property string $id
 * @property string $std
 * @property string $name
 * @property string $spell
 * @property string $desc
 * @property integer $created_at
 * @property string $price
 */
class Medicine extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'medicine';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_at', 'numerical', 'integerOnly'=>true),
			array('std, spell', 'length', 'max'=>45),
			array('name', 'length', 'max'=>100),
			array('desc', 'length', 'max'=>500),
			array('price', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, std, name, spell, desc, created_at, price', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'std' => 'Std',
			'name' => 'Name',
			'spell' => 'Spell',
			'desc' => 'Desc',
			'created_at' => 'Created At',
			'price' => 'Price',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('std',$this->std,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('spell',$this->spell,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('price',$this->price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Medicine the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * 获取药品列表
	 *
	 */
	public static function getList()
	{
		$medicine = Medicine::model()->findAll("1=1 order by created_at desc");
		$medical = array();
		foreach ($medicine as $med){
			$temp['id']="$med->id";
			$temp['bs'] = "$med->spell";
			$temp['name']="$med->name";
			array_push($medical, $temp);
		}
		if (is_array($medical)){
			return json_encode($medical);
		}else{
			return false;
		}
	}
	
	public static function getNameByID($id){
		$medicine = Medicine::model()->findAllByPk($id);
		if ($medicine){
			return $medicine[0]->name;
		}
		else {
			return '';
		}
	}
}
