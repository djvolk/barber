<?php

/**
 * This is the model class for table "tbl_contact".
 *
 * The followings are the available columns in table 'tbl_contact':
 * @property integer $id
 * @property string $field
 * @property string $value
 */
class Contact extends CActiveRecord {

    public function tableName() {
        return 'tbl_contact';
    }

    public function rules() {
        return array(
            array('field', 'required'),
            array('field', 'length', 'max' => 255),
            array('id, field, value', 'safe', 'on' => 'search'),
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
            'id'    => 'ID',
            'field' => 'Field',
            'value' => 'Value',
        );
    }

    public function getContact() {
        $query = Yii::app()->db->createCommand()
                ->select('*')
                ->from('tbl_contact')
                ->queryAll();

        foreach ($query as $row)
        {
            $result[$row['field']] = $row['value'];
        }
        return $result;
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('field', $this->field, true);
        $criteria->compare('value', $this->value, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
