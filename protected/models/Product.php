<?php

/**
 * This is the model class for table "tbl_product".
 *
 * The followings are the available columns in table 'tbl_product':
 * @property integer $id
 * @property integer $category_id
 * @property integer $in_stock
 * @property string $title
 * @property string $date
 * @property string $image
 * @property string $description
 * @property string $brief_description
 * @property string $status
 */
class Product extends CActiveRecord {

    public function tableName() {
        return 'tbl_product';
    }

    public function rules() {
        return array(
            array('title', 'required', 'message' => 'Введите название.'),
            array('brief_description', 'required', 'message' => 'Введите краткое описание.'),
            array('in_stock', 'numerical', 'integerOnly'=>true, 'message' => 'Введите число.'),
            array('image', 'file', 'allowEmpty' => true, 'types' => 'jpg,jpeg,gif,png', 'wrongType' => 'Недопустимый формат изображения.'),
            array('id, category_id, in_stock, title, date, image, description, brief_description, status', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id'                => 'ID',
            'category_id'       => 'Category',
            'in_stock'          => 'In Stock',
            'title'             => 'Title',
            'date'              => 'Date',
            'image'             => 'Image',
            'description'       => 'Description',
            'brief_description' => 'Brief Description',
            'status'            => 'Status',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('in_stock', $this->in_stock);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('brief_description', $this->brief_description, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
