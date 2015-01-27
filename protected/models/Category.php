<?php

/**
 * This is the model class for table "tbl_category".
 *
 * The followings are the available columns in table 'tbl_category':
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property integer $count
 */
class Category extends CActiveRecord {

    public function tableName() {
        return 'tbl_category';
    }

    public function rules() {
        return array(
            array('name', 'required', 'message' => 'Введите название.'),
            array('image', 'file', 'allowEmpty' => true, 'types' => 'jpg,jpeg,gif,png', 'wrongType' => 'Недопустимый формат изображения.'),
            array('id, name, image, count', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id'    => 'ID',
            'name'  => 'Name',
            'image' => 'Image',
            'count' => 'Count',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('count', $this->count);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
