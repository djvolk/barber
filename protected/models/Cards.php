<?php

/**
 * This is the model class for table "tbl_carts".
 *
 * The followings are the available columns in table 'tbl_carts':
 * @property integer $id
 * @property string $num
 * @property string $status
 * @property integer $user_id
 */
class Cards extends CActiveRecord {

    public function tableName() {
        return 'tbl_cards';
    }

    public function rules() {
        return array(
            array('num', 'required', 'message' => 'Введите номер карты.'),
            array('num', 'unique', 'message' => 'Карта с таким номером уже существует.'),
            array('status', 'required'),
            array('status', 'statusValidate'),
            array('user_id', 'user_idValidate'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('num, status', 'length', 'max' => 255),
            array('id, num, status, user_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id'      => 'ID',
            'num'     => 'Num',
            'status'  => 'Status',
            'user_id' => 'User',
        );
    }

    public function user_idValidate() {
        if ($this->user_id == '' && $this->status == 'connect')
            $this->addError('user_id', 'Если карта подключена, вам нужно указать пользователя.');
    }
    
    public function statusValidate() {
        if ($this->user_id != '' && $this->status == 'free')
            $this->addError('status', 'Если вы указали пользователя, карта не может иметь свободный статус.');
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('num', $this->num, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
