<?php

/**
 * This is the model class for table "prescription_view".
 *
 * The followings are the available columns in table 'prescription_view':
 * @property string $id
 * @property string $pname
 * @property string $etiology
 * @property string $main_id
 * @property integer $sex
 * @property integer $age
 * @property string $address
 * @property string $mname
 * @property string $spell
 * @property string $mid
 * @property string $weight
 * @property integer $amount
 * @property string $way
 * @property string $pdprice
 * @property string $mprice
 * @property string $total
 * @property integer $created_at
 */
class PrescriptionView extends CActiveRecord
{
	public $count_num;
	public $count_weight;
	public $count_amount;
	public $count_total;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'prescription_view';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sex, age, amount, created_at', 'numerical', 'integerOnly'=>true),
			array('id, main_id, mid', 'length', 'max'=>10),
			array('pname, spell', 'length', 'max'=>45),
			array('etiology', 'length', 'max'=>500),
			array('address, way', 'length', 'max'=>255),
			array('mname', 'length', 'max'=>100),
			array('weight, pdprice, mprice', 'length', 'max'=>6),
			array('total', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pname, etiology, main_id, sex, age, address, mname, spell, mid, weight, amount, way, pdprice, mprice, total, created_at', 'safe', 'on'=>'search'),
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
			'pname' => 'Pname',
			'etiology' => 'Etiology',
			'main_id' => 'Main',
			'sex' => 'Sex',
			'age' => 'Age',
			'address' => 'Address',
			'mname' => 'Mname',
			'spell' => 'Spell',
			'mid' => 'Mid',
			'weight' => 'Weight',
			'amount' => 'Amount',
			'way' => 'Way',
			'pdprice' => 'Pdprice',
			'mprice' => 'Mprice',
			'total' => 'Total',
			'created_at' => 'Created At',
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
		$criteria->compare('pname',$this->pname,true);
		$criteria->compare('etiology',$this->etiology,true);
		$criteria->compare('main_id',$this->main_id,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('age',$this->age);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('mname',$this->mname,true);
		$criteria->compare('spell',$this->spell,true);
		$criteria->compare('mid',$this->mid,true);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('way',$this->way,true);
		$criteria->compare('pdprice',$this->pdprice,true);
		$criteria->compare('mprice',$this->mprice,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('created_at',$this->created_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PrescriptionView the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
