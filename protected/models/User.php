<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $mail
 * @property string $password
 * @property datetime $date
 * @property string $phone
 * @property integer $code
 * @property string $name
 * @property string $surname
 * @property string $card
 * @property string $status
 * @property string $role
 */
class User extends CActiveRecord {

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const ROLE_BANNED = 'banned';

    var $pass;

    public function tableName() {
        return 'tbl_user';
    }

    public function rules() {
        return array(
            array('mail', 'required', 'message' => 'Пожалуйста, введите email.'),
            array('password', 'required', 'message' => 'Пожалуйста, введите пароль.'),
            array('phone', 'required', 'message' => 'Пожалуйста, введите телефон.', 'on' => 'registration'),
            array('name', 'required', 'message' => 'Пожалуйста, введите Имя.', 'on' => 'registration'),
            array('surname', 'required', 'message' => 'Пожалуйста, введите Фамилию.', 'on' => 'registration'),
            array('mail', 'match', 'pattern' => '#^[0-9a-z]+[-\._0-9a-z]*@[0-9a-z]+[-\._^0-9a-z]*[0-9a-z]+[\.]{1}[a-z]{2,6}$#i', 'message' => 'Email недопустимого формата.'),
            array('mail', 'unique', 'caseSensitive' => true, 'allowEmpty' => true, 'message' => 'Email уже зарегистрирован.', 'on' => 'registration'),
            array('password', 'length', 'min' => 6, 'tooShort' => 'Пароль слишком короткий.'),
            array('card', 'cardValidate'),
            array('password', 'authenticate', 'on' => 'login'),
            array('phone', 'unique', 'caseSensitive' => true, 'allowEmpty' => true, 'message' => 'Номер уже зарегистрирован.', 'on' => 'registration'),
            array('phone', 'length', 'min' => 12, 'max' => 12, 'tooShort' => 'Номер введен неверно.', 'tooLong' => 'Номер введен неверно.', 'on' => 'registration'),
            array('id, mail, password, date, phone, code, name, surname, card, status, role', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id'       => 'ID',
            'mail'     => 'Mail',
            'password' => 'Password',
            'date'     => 'Date',
            'phone'    => 'Phone',
            'code'     => 'Code',
            'name'     => 'Name',
            'surname'  => 'Surname',
            'card'     => 'Cart',
            'status'   => 'Status',
            'role'     => 'Role',
        );
    }

    public function cardValidate() {

        if (!empty($this->card))
        {
            $query = Yii::app()->db->createCommand()
                    ->select('count(*), id')
                    ->from('tbl_cards')
                    ->where('num = "'.$this->card.'" AND status = "free"')
                    ->queryRow();

            if ($query["count(*)"] == 0)
                $this->addError('card', 'Номер карты неверный.<br>Если у вас нет карты, оставьте это поле пустым.');
        }
    }

    public function authenticate($attribute, $params) {
        // Проверяем были ли ошибки в других правилах валидации.
        // если были - нет смысла выполнять проверку
        if (!$this->hasErrors())
        {
            // Создаем экземпляр класса UserIdentity
            // и передаем в его конструктор введенный пользователем логин и пароль (с формы)
            $identity = new UserIdentity($this->mail, $this->password);
            // Выполняем метод authenticate (о котором мы с вами говорили пару абзацев назад)
            // Он у нас проверяет существует ли такой пользователь и возвращает ошибку (если она есть)
            // в $identity->errorCode
            $identity->authenticate();

            // Теперь мы проверяем есть ли ошибка..
            switch ($identity->errorCode) {
                // Если ошибки нету...
                case UserIdentity::ERROR_NONE: {
                        // Данная строчка говорит что надо выдать пользователю
                        // соответствующие куки о том что он зарегистрирован, срок действий
                        // у которых указан вторым параметром.
                        Yii::app()->user->login($identity, 3600 * 24 * 300);
                        break;
                    }
                case UserIdentity::ERROR_USERNAME_INVALID: {
                        // Если логин был указан наверно - создаем ошибку
                        $this->addError('mail', 'Не верно введен mail или пароль.');
                        $this->addError('password', 'Не верно введен mail или пароль.');
                        break;
                    }
                case UserIdentity::ERROR_PASSWORD_INVALID: {
                        // Если пароль был указан наверно - создаем ошибку
                        $this->addError('mail', 'Не верно введен mail или пароль.');
                        $this->addError('password', 'Не верно введен mail или пароль.');
                        break;
                    }
            }
        }
    }

    public function getFullName() {
        return $this->surname." ".$this->name;
    }

    public function generate_code($number) {
        $arr = array('1', '2', '3', '4', '5', '6',
            '7', '8', '9', '0');

        $pass = "";
        for ($i = 0; $i < $number; $i++)
        {
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
        return $pass;
    }

    public function generate_password($number) {
        $arr = array('1', '2', '3', '4', '5', '6',
            '7', '8', '9', '0', 'a', 'b', 'c', 'd', 'e', 'f',
            'g', 'h', 'i', 'j', 'k', 'l',
            'm', 'n', 'o', 'p', 'r', 's',
            't', 'u', 'v', 'x', 'y', 'z');

        $pass = "";
        for ($i = 0; $i < $number; $i++)
        {
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
        return $pass;
    }

    public function checkText($text) {

        $query_mail = Yii::app()->db->createCommand()
                ->select('*')
                ->from('tbl_user')
                ->where('mail ="'.$text.'"')
                ->queryRow();
        if ($query_mail)
        {
            $new_pass = User::model()->generate_password(8);
            $query = Yii::app()->db->createCommand()
                    ->update('tbl_user', array(
                'password' => md5($new_pass),
                    ), 'id=:id', array(':id' => $query_mail['id']));

            if ($query)
            {
                $mail = Settings::model()->findByAttributes(array('field' => 'mail'));

                $to = $query_mail['mail'];
                $subject = 'Новый пароль - Салон Валерия Аксенова';
                $message = 'Здравствуйте, '.$query_mail['name'].". \r\n".'Ваш новый пароль: '.$new_pass."\r\n".'Пожалуйста, не сообщайте его никому.';
                $headers = 'From: '.$mail['value']."\r\n".
                        'Reply-To: '.$mail['value']."\r\n".
                        'X-Mailer: PHP/'.phpversion();

                mail($to, $subject, $message, $headers);
                $status = 'success';
            } else
                $status = 'error';
        } elseif (strlen($text) > 10)
        {
            $phone = preg_replace("/\D/", "", $text);
            $phone = substr($phone, 1);
            if ($phone)
            {
                $query_phone = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('tbl_user')
                        ->where('phone LIKE "%'.$phone.'%"')
                        ->queryRow();
                if ($query_phone)
                {
                    $new_pass = User::model()->generate_password(8);
                    $query = Yii::app()->db->createCommand()
                            ->update('tbl_user', array(
                        'password' => md5($new_pass),
                            ), 'id=:id', array(':id' => $query_phone['id']));

                    if ($query)
                    {
                        $sms = Settings::model()->getSMSSettings();
                        Yii::app()->smspilot->send($query_phone['phone'], 'Ваш новый пароль: '.$new_pass, 'aksenovlook');
                        $status = 'success';
                    } else
                        $status = 'error';
                } else
                {
                    $status = 'fail';
                }
            } else
            {
                $status = 'fail';
            }
        } else
        {
            $status = 'fail';
        }

        return $status;
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('mail', $this->mail, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('code', $this->code);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('surname', $this->surname, true);
        $criteria->compare('card', $this->card, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('role', $this->role, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
