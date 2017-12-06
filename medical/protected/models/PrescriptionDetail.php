<?php

/**
 * This is the model class for table "prescription_detail".
 *
 * The followings are the available columns in table 'prescription_detail':
 * @property string $id
 * @property integer $prescription_id
 * @property integer $medicine_id
 * @property string $medicine_name
 * @property string $weight
 * @property integer $amount
 * @property string $price
 * @property string $total
 */
class PrescriptionDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'prescription_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prescription_id, medicine_id, amount', 'numerical', 'integerOnly'=>true),
			array('medicine_name', 'length', 'max'=>45),
			array('weight, price', 'length', 'max'=>6),
			array('total', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, prescription_id, medicine_id, medicine_name, weight, amount, price, total', 'safe', 'on'=>'search'),
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
			'prescription_id' => 'Prescription',
			'medicine_id' => 'Medicine',
			'medicine_name' => 'Medicine Name',
			'weight' => 'Weight',
			'amount' => 'Amount',
			'price' => 'Price',
			'total' => 'Total',
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
		$criteria->compare('prescription_id',$this->prescription_id);
		$criteria->compare('medicine_id',$this->medicine_id);
		$criteria->compare('medicine_name',$this->medicine_name,true);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('total',$this->total,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PrescriptionDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
