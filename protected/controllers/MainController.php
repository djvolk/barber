<?php

class MainController extends Controller {

    public $layout = '//layouts/column1';
    public $description = '';
    public $keywords = '';

    public function filters() {
        return array(
            'accessControl',
            'postOnly + delete',
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('Index', 'Error', 'Main',
                    'Registration', 'Login', 'Logout', 'ForgotPassword', 'LoginUser', 'LoginAdmin', 'OpenRegistration', 'EndRegistration',
                    'Service',
                    'Reserv', 'SaveReserv', 'UpdateTimeGroup',
                    'ShopCategories', 'ShopProducts', 'ShopProduct',
                    'Contact',
                    'News', 'NewsRead',
                    'Gallery',
                ),
                'users'   => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(''),
                'roles'   => array('user'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(''),
                'roles'   => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionService() {

        $service = Page::model()->findByAttributes(array('page' => 'service'));
        $reviews = Page::model()->findByAttributes(array('page' => 'reviews'));
        $images = Gallery::model()->findAll($criteria);

        $this->renderPartial('service', array(
            'service' => $service,
            'reviews' => $reviews,
            'images'  => $images,
                ), false, true);
    }

    public function actionReserv() {

        $month = Settings::model()->getMonthName();
        $time = Settings::model()->getTime();

        if (date('H') > $time['end']['H'])                                      //если сегодня уже поздно
            $date['num'] = time() + 86400;                                      //выставляем завтра
        else
            $date['num'] = time();                                              //выставляем дату "сегодня"

        $operations = Operations::model()->findAll();
        $date['string'] = date("j", $date['num']).' '.$month[date("n", $date['num'])].' '.date("Y", $date['num']);                                         //дата в строку для отображения
        $date['time_start'] = mktime($time['start']['H'], $time['start']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));
        $date['time_end'] = mktime($time['end']['H'], $time['end']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));
        $date['period'] = Settings::model()->getPeriod();

        $criteria = new CDbCriteria;
        $criteria->condition = 'date = "'.date("d-m-Y", $date['num']).'"';
        $reserved = Reserv::model()->findAll($criteria);

        $this->renderPartial('reserv', array(
            'date'      => $date,
            'reserved'  => $reserved,
            'operations' => $operations,
                ), false, true);
    }

    public function actionUpdateTimeGroup() {

        $month = Settings::model()->getMonthName();
        $time = Settings::model()->getTime();

        $date['num'] = $_POST['date'];

        $date['string'] = date("j", $date['num']).' '.$month[date("n", $date['num'])].' '.date("Y", $date['num']);                                         //дата в строку для отображения
        $date['time_start'] = mktime($time['start']['H'], $time['start']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));
        $date['time_end'] = mktime($time['end']['H'], $time['end']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));
        $date['period'] = Settings::model()->getPeriod();

        $criteria = new CDbCriteria;
        $criteria->condition = 'date = "'.date("d-m-Y", $date['num']).'"';
        $reserved = Reserv::model()->findAll($criteria);

        $this->renderPartial('_timeGroup', array(
            'date'     => $date,
            'reserved' => $reserved,
                ), false, true);
    }

    public function actionSaveReserv() {

        if (Yii::app()->request->isAjaxRequest)
        {
            $operation = Operations::model()->findByAttributes(array('name' => $_POST['operation']));

            $user = User::model()->findByAttributes(array('phone' => $_POST['phone']));
            if (!isset($user))
            {
                $user = new User;
                $user->phone = $_POST['phone'];
                $user->role = 'guest';
                $user->date = new CDbExpression('NOW()');
                $user->save();
                $user = User::model()->findByAttributes(array('phone' => $_POST['phone']));
            }
            if (Yii::app()->user->isGuest)
                Yii::app()->request->cookies['phone'] = new CHttpCookie('phone', $_POST['phone']);

            $reserv = new Reserv;
            $reserv->operation_id = $operation['id'];
            $reserv->user_id = $user['id'];
            $reserv->time_start = $_POST['time'];
            $reserv->time_end = $_POST['time'] + ($operation['time'] * 60);
            $reserv->date = date('d-m-Y', $_POST['date']);
            $reserv->status = 'new';
            if ($reserv->save())
            {
                $phone = Contact::model()->findByAttributes(array('field' => 'phone'));
                $latlongmet = Contact::model()->findByAttributes(array('field' => 'latlongmet'));
                $mapzoom = Contact::model()->findByAttributes(array('field' => 'mapzoom'));
                $latlongcenter = Contact::model()->findByAttributes(array('field' => 'latlongcenter'));

                $contact = array('phone'         => $phone['value'],
                    'latlongmet'    => $latlongmet['value'],
                    'mapzoom'       => $mapzoom['value'],
                    'latlongcenter' => $latlongcenter['value']);

                $month = Settings::model()->getMonthName();
                $result['name'] = $operation['name'];
                $result['duration'] = $operation['time'];
                $result['price'] = $operation['price'];
                $result['comment'] = $operation['comment'];
                $result['date'] = date("j", $reserv['time_start']).' '.$month[date("n", $reserv['time_start'])];
                $result['start'] = date("H:i", $reserv['time_start']);
                $result['end'] = date("H:i", $reserv['time_end']);
                
                echo CJSON::encode(array(
                    'status' => 'success',
                    'html'   => $this->renderPartial('reservSuccess', array('contact' => $contact, 'reserv' => $result), true)));
            } else
            {
                $error = $reserv->getErrors();
                echo CJSON::encode(array(
                    'status' => 'error',
                    'html'   => '<div class="errorMessage"><strong>Упс, как так!</strong> '.$error['time_start'][0].'</div>',));
            }
        }
    }

    public function actionShopCategories() {

        $criteria = new CDbCriteria;
        $criteria->order = 'name ASC';
        $categories = Category::model()->findAll($criteria);

        $page = Page::model()->findByAttributes(array('page' => 'shop'));
        $this->renderPartial('shopCategories', array(
            'categories' => $categories,
            'page'       => $page,
                ), false, false);
    }

    public function actionShopProducts() {

        $category = Category::model()->findByPk($_POST['id']);

        $criteria = new CDbCriteria;
        $criteria->condition = 'category_id = '.$_POST['id'];
        $criteria->order = 'id DESC';

        $count = Product::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);

        $products = Product::model()->findAll($criteria);
        $this->renderPartial('shopProducts', array(
            'products' => $products,
            'pages'    => $pages,
            'category' => $category
                ), false, false);
    }

    public function actionShopProduct() {

        $product = Product::model()->findByPk($_POST['id']);
        $category = Category::model()->findByPk($product->category_id);

        $this->renderPartial('shopProduct', array(
            'product'  => $product,
            'category' => $category,
                ), false, false);
    }

    public function actionContact() {

        $phone = Contact::model()->findByAttributes(array('field' => 'phone'));
        $address = Contact::model()->findByAttributes(array('field' => 'address'));
        $info = Contact::model()->findByAttributes(array('field' => 'info'));
        $email = Contact::model()->findByAttributes(array('field' => 'email'));
        $latlongmet = Contact::model()->findByAttributes(array('field' => 'latlongmet'));
        $mapzoom = Contact::model()->findByAttributes(array('field' => 'mapzoom'));
        $latlongcenter = Contact::model()->findByAttributes(array('field' => 'latlongcenter'));

        $contact = array('phone'         => $phone['value'],
            'address'       => $address['value'],
            'info'          => $info['value'],
            'email'         => $email['value'],
            'latlongmet'    => $latlongmet['value'],
            'mapzoom'       => $mapzoom['value'],
            'latlongcenter' => $latlongcenter['value']);

        $this->renderPartial('contact', array(
            'contact' => $contact,
                ), false, true);
    }

    public function actionNews() {

        if ($_POST['page'])
            $_GET['page'] = $_POST['page'];

        $criteria = new CDbCriteria;
        $criteria->order = 'id DESC';
        $criteria->condition = 'status = "show"';
        $count = News::model()->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = 7;
        $pages->applyLimit($criteria);

        $news = News::model()->findAll($criteria);

        $month = Settings::model()->getMonthName();
        $this->renderPartial('news', array(
            'news'  => $news,
            'pages' => $pages,
            'month' => $month,
                ), false, false);
    }

    public function actionNewsRead() {

        $news = News::model()->findByPk($_POST['id']);
        $page = $_POST['page'];

        $month = Settings::model()->getMonthName();
        $this->renderPartial('newsRead', array(
            'news'  => $news,
            'page'  => $page,
            'month' => $month,
                ), false, false);
    }

    public function actionGallery() {

        $criteria = new CDbCriteria;
        $criteria->order = 'id DESC';
        $count = Gallery::model()->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = 9;
        $pages->applyLimit($criteria);

        $images = Gallery::model()->findAll($criteria);

        $page = Page::model()->findByAttributes(array('page' => 'gallery'));

        $month = Settings::model()->getMonthName();
        $this->renderPartial('gallery', array(
            'images' => $images,
            'pages'  => $pages,
            'page'   => $page,
                ), false, false);
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error)
        {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->renderPartial('error', $error);
        }
    }

    public function actionLogin() {
        $form = new User();

        if (Yii::app()->user->isGuest)
        {
            if (isset($_POST['User']))
            {
                $form->phone = $_POST['User']['phone'];
                $form->password = md5($_POST['User']['password']);
                $form->scenario = 'login';
                if ($form->validate())
                {
                    $user = User::model()->findByPk($form->phone);
                    Yii::app()->request->cookies['phone'] = new CHttpCookie('phone', $form->phone);
                    $this->renderPartial('loginGood', array('user' => $user), false, true);
                } else
                {
                    $form->password = $_POST['User']['password'];
                    $this->renderPartial('login', array('form' => $form), false, true);
                }
            }
        } elseif (Yii::app()->user->role == 'user')
        {
            $this->renderPartial('loginGood');
        }
    }

    public function actionLoginAdmin() {
        $form = new User();
        $form->mail = '1@mail.ru';
        $form->password = md5('123456');
        $form->scenario = 'login';
        $form->validate();
    }

    public function actionLoginUser() {
        $form = new User();
        $form->mail = '2@mail.ru';
        $form->password = md5('123456');
        $form->scenario = 'login';
        $form->validate();
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $form = new User();
        $this->renderPartial('login', array('form' => $form), false, true);
    }

    public function actionOpenRegistration() {
        $form = new User();
        $this->renderPartial('registration', array(
            'form' => $form,
                ), false, true);
    }

    public function actionRegistration() {
        if (Yii::app()->request->isAjaxRequest)
        {
            $form = new User();

            if (isset($_POST['User']))
            {
                $form->password = strip_tags($_POST['User']['password']);                                        //добавляем +
                $form->phone = $_POST['User']['phone'];
                $form->card = strip_tags($_POST['User']['card']);
                $form->scenario = 'registration';

                if (!empty($_POST['code']))                                     //если введен код подтверждения телефона
                {
                    if (md5($_POST['code']) != Yii::app()->session['code'])     //код введен неверно
                    {
                        $form->addError('code', 'Код введен неверно.');        //добавляем ошибку
                        echo CJSON::encode(array(
                            'status' => 'code',
                            'html'   => $this->renderPartial('registration', array('form' => $form), true)));
                        exit();
                    } else
                    {
                        $form->password = md5(strip_tags($_POST['User']['password']));    //записываем пароль в md5
                        $form->role = 'user';                                             //выставляем роль
                        $form->date = new CDbExpression('NOW()');                         //дата регистрации
                        $form->save();                                                    //сохраняем пользователя                  
                        $identity = new UserIdentity($form->phone, $form->password);      //создаем экземляр дял логина
                        $identity->authenticate();                                        //проверка логина, пароля
                        Yii::app()->user->login($identity, 3600 * 24 * 300);              //логинимся (время хранения кук)
                        if (!empty($form->card))
                        {
                            $card = Cards::model()->findByAttributes(array('num' => $form->card));
                            $card->status = "connect";
                            $card->user_id = $form->id;
                            $card->save();
                        }
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'html'   => $this->renderPartial('registrationSuccess', array('form' => $form), true)));
                        exit();
                    }
                }


                if ($form->validate())
                {
                    $form->code = User::model()->generate_code(6);
                    //if (Yii::app()->smspilot->send($form->phone, 'Код проверки телефона: '.$form->code, 'aksenovlook')) 
                    if (isset($form->code))
                    {
                        $session = Yii::app()->session;
                        $session['code2'] = ($form->code);                      //открываем сессию
                        $session['code'] = md5($form->code);                    //записываем код в сессию в md5
                        echo CJSON::encode(array(
                            'status' => 'code',
                            'html'   => $this->renderPartial('registration', array('form' => $form), true)));
                    } else
                    {
                        $form->addError('phone', 'Невозможно отправить код на телефон. Проверьте правильность номера или свяжитесь с администрацией.');
                        echo CJSON::encode(array(
                            'status' => 'error',
                            'html'   => $this->renderPartial('registration', array('form' => $form), true)));
                    }
                }
            }
        }
    }

    public function actionEndRegistration() {
        if (Yii::app()->request->isAjaxRequest)
        {
            $form = new User();

            if (isset($_POST['User']))
            {
                $form->password = strip_tags($_POST['User']['password']);                                        //добавляем +
                $form->phone = $_POST['User']['phone'];
                $form->card = strip_tags($_POST['User']['card']);
                $form->scenario = 'registration';

                if (md5($_POST['code']) != Yii::app()->session['code'])     //код введен неверно
                {
                    $form->addError('code', 'Код введен неверно.');        //добавляем ошибку
                    echo CJSON::encode(array(
                        'status' => 'code',
                        'html'   => $this->renderPartial('registration', array('form' => $form), true)));
                    exit();
                } else
                {
                    $form->password = md5(strip_tags($_POST['User']['password']));    //записываем пароль в md5
                    $form->role = 'user';                                             //выставляем роль
                    $form->date = new CDbExpression('NOW()');                         //дата регистрации
                    $form->save();                                                    //сохраняем пользователя                  
                    $identity = new UserIdentity($form->phone, $form->password);      //создаем экземляр дял логина
                    $identity->authenticate();                                        //проверка логина, пароля
                    Yii::app()->user->login($identity, 3600 * 24 * 300);              //логинимся (время хранения кук)
                    Yii::app()->request->cookies['phone'] = new CHttpCookie('phone', $form->phone);
                    if (!empty($form->card))
                    {
                        $card = Cards::model()->findByAttributes(array('num' => $form->card));
                        $card->status = "connect";
                        $card->user_id = $form->id;
                        $card->save();
                    }
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'html'   => $this->renderPartial('registrationSuccess', array('form' => $form), true)));
                }
            }
        }
    }

    public function actionForgotPassword() {

        if ($_POST['text'])
        {
            $status = User::model()->checkText($_POST['text']);
        }

        $this->renderPartial('forgotPassword', array(
            'status' => $status,
            'form'   => $form,
                ), false, true);
    }

    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
