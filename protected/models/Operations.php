<?php

/**
 * This is the model class for table "tbl_operations".
 *
 * The followings are the available columns in table 'tbl_operations':
 * @property integer $id
 * @property string $name
 * @property integer $time
 * @property integer $price
 * @property integer $discount_price
 * @property string $comment
 */
class Operations extends CActiveRecord
{
	public function tableName()
	{
		return 'tbl_operations';
	}

	public function rules()
	{
		return array(
                        array('name', 'required', 'message' => 'Введите название.'),
                        array('time', 'required', 'message' => 'Введите время.'),
                        array('price', 'required', 'message' => 'Введите цену.'),
			array('time, price', 'numerical', 'integerOnly'=>true, 'message' => 'Введите число.'),
			array('name', 'length', 'max'=>255),
			array('id, name, time, price, comment, discount_price', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'time' => 'Время',
			'price' => 'Стоимость',
                        'discount_price' => 'Стоимость по карте',
			'comment' => 'Комментарий',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('time',$this->time);
		$criteria->compare('price',$this->price);
                $criteria->compare('discount_price',$this->discount_price);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
