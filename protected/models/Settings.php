<?php

/**
 * This is the model class for table "tbl_settings".
 *
 * The followings are the available columns in table 'tbl_settings':
 * @property integer $id
 * @property string $field
 * @property string $value
 */
class Settings extends CActiveRecord {

    public function tableName() {
        return 'tbl_settings';
    }

    public function rules() {
        return array(
            array('field, value', 'required'),
            array('field', 'length', 'max' => 255),
            array('id, field, value', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
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

    public function getSMSSettings() {
        $query = Yii::app()->db->createCommand()
                ->select('*')
                ->from('tbl_settings')
                ->where('field = "sms" OR field = "sms_phone"')
                ->queryAll();

        foreach ($query as $row)
        {
            $result[$row['field']] = $row['value'];
        }

        return $result;
    }

//получаем настройки для отправки SMS администратору

    public function getSettings() {
        $query = Yii::app()->db->createCommand()
                ->select('*')
                ->from('tbl_settings')
                ->queryAll();

        foreach ($query as $row)
        {
            $result[$row['field']] = $row['value'];
        }

        if ($result['sms'] == 'true')
            $result['checkbox-sms'] = 'checked';
        else
            $result['checkbox-sms'] = '';

        return $result;
    }

//получаем настройки для страницы настроек

    public function getPeriodSetting() {
        $result[] = array('value' => '20', 'text' => 'каждые 20 минут');
        $result[] = array('value' => '30', 'text' => 'каждые 30 минут');
        $result[] = array('value' => '60', 'text' => 'каждые час');

        return $result;
    }

//dropDownList для селектора периодов на странице настроек

    public function getTimeSetting() {

        $query = Yii::app()->db->createCommand()
                ->select('value')
                ->from('tbl_settings')
                ->where('field = "period_day"')
                ->queryRow();
        $period = $query['value'];

        for ($time = mktime(0, 0, 0, 0, 0, 0); $time <= mktime(0, 0, 0, 0, 1, 0); $time = $time + (60 * $period))
        {
            $result[] = array('value' => date('H:i', $time), 'text' => date('H:i', $time));
        }

        return $result;
    }

//dropDownList для селектора времени на странице настроек

    public function getPeriod() {
        $period = Settings::model()->findByAttributes(array('field' => 'period_day'));
        return $period->value;
    }

//значение настройки период (для страниц брони)

    public function getTime() {

        $start = Settings::model()->findByAttributes(array('field' => 'start_day'));
        $start = strtotime($start->value);
        $end = Settings::model()->findByAttributes(array('field' => 'end_day'));
        $end = strtotime($end->value);

        $result['start']['i'] = date('i', $start);                                //минуты начала рабочего дня
        $result['start']['H'] = date('H', $start);                                //часы начала рабочего дня
        $result['end']['i'] = date('i', $end);                                    //минуты конца рабочего дня
        $result['end']['H'] = date('H', $end);                                    //часы конца рабочего дня

        return $result;
    }

//время начала и конца рабочего дня (для страниц брони)

    public function getMonthName() {

        return array(1  => 'января',
            2  => 'февраля',
            3  => 'марта',
            4  => 'апреля',
            5  => 'мая',
            6  => 'июня',
            7  => 'июля',
            8  => 'августа',
            9  => 'сентября',
            10 => 'октября',
            11 => 'ноября',
            12 => 'декабря');
    }

//русское название месяца

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
