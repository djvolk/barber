<?php

/**
 * This is the model class for table "tbl_gallery".
 *
 * The followings are the available columns in table 'tbl_gallery':
 * @property integer $id
 * @property string $date
 * @property string $title
 * @property string $image
 * @property string $status
 */
class Gallery extends CActiveRecord
{
	public function tableName()
	{
		return 'tbl_gallery';
	}

	public function rules()
	{
		return array(
			array('image', 'file', 'allowEmpty'=>true, 'types'=>'jpg,jpeg,gif,png', 'wrongType' => 'Недопустимый формат изображения.'),
			array('id, date, title, image, status', 'safe', 'on'=>'search'),
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
			'date' => 'Date',
			'title' => 'Title',
			'image' => 'Image',
			'status' => 'Status',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
