<?php

/**
 * This is the model class for table "tbl_news".
 *
 * The followings are the available columns in table 'tbl_news':
 * @property integer $id
 * @property string $date
 * @property string $title
 * @property string $text
 * @property string $pic
 * @property integer $like
 * @property string $status
 */
class News extends CActiveRecord {


    public function tableName() {
        return 'tbl_news';
    }

    public function rules() {
        return array(           
            array('title', 'required', 'message' => 'Введите заголовок.'),
            array('text', 'required', 'message' => 'Введите текст.'),           
            array('pic', 'file', 'allowEmpty'=>true, 'types'=>'jpg,jpeg,gif,png', 'wrongType' => 'Недопустимый формат изображения.'),
            array('id, date, title, text, pic, like, status', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id'     => 'ID',
            'date'   => 'Date',
            'title'  => 'Title',
            'text'   => 'Text',
            'pic'    => 'Pic',
            'like'   => 'Like',
            'status' => 'Status',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('pic', $this->pic, true);
        $criteria->compare('like', $this->like);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
