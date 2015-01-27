<?php

/**
 * This is the model class for table "tbl_slider".
 *
 * The followings are the available columns in table 'tbl_slider':
 * @property integer $id
 * @property integer $image
 * @property integer $comment
 */
class Slider extends CActiveRecord {

    public function tableName() {
        return 'tbl_slider';
    }

    public function rules() {
        return array(
            array('image, comment', 'required'),
            array('comment', 'required', 'message' => 'Введите текст.'),
            array('image', 'file', 'allowEmpty' => true, 'types' => 'jpg,jpeg,gif,png', 'message' => 'Ой! Вы забыли загрузить фотографию!', 'wrongType' => 'Недопустимый формат изображения.'),
            array('id, image, comment', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id'      => 'ID',
            'image'   => 'Image',
            'comment' => 'Comment',
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('image', $this->image);
        $criteria->compare('comment', $this->comment);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
