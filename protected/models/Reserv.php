<?php

/**
 * This is the model class for table "tbl_reserv".
 *
 * The followings are the available columns in table 'tbl_reserv':
 * @property integer $id
 * @property integer $user_id
 * @property integer $operation_id
 * @property string $time_start
 * @property string $time_end
 * @property string $date
 * @property string $comment
 * @property string $status
 */
class Reserv extends CActiveRecord {

    public function tableName() {
        return 'tbl_reserv';
    }

    public function rules() {
        return array(
            array('user_id, operation_id, time_start, date, status', 'required'),
            array('user_id, operation_id', 'numerical', 'integerOnly' => true),
            array('time_start', 'time_startValidate'),
            array('status', 'length', 'max' => 255),
            array('time_end', 'safe'),
            array('id, user_id, operation_id, time_start, time_end, date, comment, status', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id'           => 'ID',
            'user_id'      => 'User',
            'operation_id' => 'Operation',
            'time_start'   => 'Time Start',
            'time_end'     => 'Time End',
            'date'         => 'Date',
            'comment'      => 'Comment',
            'status'       => 'Status',
        );
    }

    public function time_startValidate() {
        if ($this->time_start <= time())
            $this->addError('time_start', 'Это время уже прошло. Пожалуйста, выберите ещё не наступившие дату у время.');

        if (isset($this->id))
            $id_condition = 'AND  id != '.$this->id;
        else
            $id_condition = '';

        $query = Yii::app()->db->createCommand()
                ->select('*')
                ->from('tbl_reserv')
                ->where('(status NOT IN ("bad", "bad_by_user")) AND date = "'.$this->date.'" '.$id_condition)
                ->queryAll();

        foreach ($query as $row)
        {
            if ($this->time_start == $row['time_start'])
                $this->addError('time_start', 'На это время уже есть запись. Пожалуйста, выберите другое время.');
            if ($this->time_start < $row['time_start'])
                if ($this->time_end > $row['time_start'])
                    $this->addError('time_start', 'Следующий клиент придет раньше, чем работа с вами закончится. Пожалуйста, выберите другое время.');
        }
    }

    public function getUserReserv() {                                           //информация об актуальной брони
        $query = Yii::app()->db->createCommand()
                ->select('*')
                ->from('tbl_reserv')
                ->where('user_id = '.Yii::app()->user->id.' AND time_start > '.time().' AND (status IN ("new", "reserved"))')
                ->limit(1)
                ->queryRow();

        if (count($query) > 1)
        {
            $month = Settings::model()->getMonthName();
            $result = $query;                                                   //информация о броне

            $operation = Operations::model()->findByPk($query['operation_id']); //информация об услуге
            $result['name'] = $operation['name'];
            $result['duration'] = $operation['time'];
            $result['discount_price'] = $operation['discount_price'];
            $result['price'] = $operation['price'];
            $result['comment'] = $operation['comment'];

            $result['date'] = date("j", $result['time_start']).' '.$month[date("n", $result['time_start'])];
            $result['start'] = date("H:i", $result['time_start']);
            $result['end'] = date("H:i", $result['time_end']);

            if ($result['status'] == 'reserved')
            {
                $result['panel_class'] = 'panel panel-red';
                $result['panel-title'] = 'Вы уже записались:';
                $result['button'] = 'btn btn-danger';
            } elseif ($result['status'] == 'new')
            {
                $result['panel_class'] = 'panel panel-yellow';
                $result['panel-title'] = 'Вы уже записались: (вашу запись ещё не подтвердили)';
                $result['button'] = 'btn btn-warning';
            }
        } else
            $result['status'] = 'clear';                                        //статус

        return $result;
    }

    public function getReserv($status) {                                           //информация об актуальной брони
        $query = Yii::app()->db->createCommand()
                ->select('*')
                ->from('tbl_reserv')
                ->where('(status IN ('.$status.'))')
                ->queryAll();

        if (isset($query))
            foreach ($query as $row)
            {
                $month = Settings::model()->getMonthName();
                $operation = Operations::model()->findByPk($row['operation_id']); //информация об услуге
                $user = User::model()->findByPk($row['user_id']);

                $result[$i] = $row;
                $result[$i]['name'] = $operation['name'];
                $result[$i]['duration'] = $operation['time'];
                $result[$i]['price'] = $operation['price'];
                $result[$i]['discount_price'] = $operation['discount_price'];
                $result[$i]['comment'] = $operation['comment'];

                $result[$i]['firstname'] = $user['name'];
                $result[$i]['surname'] = $user['surname'];
                $result[$i]['card'] = $user['card'];
                $result[$i]['phone'] = $user['phone'];

                $result[$i]['date'] = date("j", $result[$i]['time_start']).' '.$month[date("n", $result[$i]['time_start'])];
                $result[$i]['start'] = date("H:i", $result[$i]['time_start']);
                $result[$i]['end'] = date("H:i", $result[$i]['time_end']);
                $i++;
            }
        return $result;
    }

    public function getReservItem($id) {                                           //информация об актуальной брони
        $query = Yii::app()->db->createCommand()
                ->select('*')
                ->from('tbl_reserv')
                ->where('id ='.$id)
                ->queryRow();

        if (count($query) > 1)
        {
            $month = Settings::model()->getMonthName();
            $operation = Operations::model()->findByPk($query['operation_id']); //информация об услуге
            $user = User::model()->findByPk($query['user_id']);

            $result = $query;
            $result['name'] = $operation['name'];
            $result['duration'] = $operation['time'];
            $result['price'] = $operation['price'];
            $result['discount_price'] = $operation['discount_price'];
            //$result['comment'] = $operation['comment'];

            $result['firstname'] = $user['name'];
            $result['surname'] = $user['surname'];
            $result['phone'] = $user['phone'];
            $result['card'] = $user['card'];

            $result['date'] = date("j", $result['time_start']).' '.$month[date("n", $result['time_start'])];
            $result['start'] = date("H:i", $result['time_start']);
            $result['end'] = date("H:i", $result['time_end']);
        }

        return $result;
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('operation_id', $this->operation_id);
        $criteria->compare('time_start', $this->time_start, true);
        $criteria->compare('time_end', $this->time_end, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
