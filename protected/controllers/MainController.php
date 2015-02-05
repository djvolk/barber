<?php

class MainController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'accessControl',
            'postOnly + delete',
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('Index', 'Error',
                    'Registration', 'Login', 'Logout', 'ForgotPassword', 'LoginUser', 'LoginAdmin',
                    'News', 'NewsRead',
                    'Gallery',
                    'Service',
                    'ShopCategories', 'ShopProducts', 'ShopProduct',
                    'Contact'),
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

        $form = new User();
        $this->render('index', array('form' => $form));
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

    public function actionService() {

        $page = Page::model()->findByAttributes(array('page' => 'service'));
        $this->renderPartial('service', array(
            'page' => $page,
                ), false, true);
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
                $form->mail = $_POST['User']['mail'];
                $form->password = md5($_POST['User']['password']);
                $form->scenario = 'login';
                if ($form->validate())
                {
                    $user = User::model()->findByPk($form->mail);
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

    public function actionRegistration() {

        if (Yii::app()->user->isGuest)
        {
            $form = new User();
            $form->phone = '+7';                                                //placeholder телефона
            if (isset($_POST['User']))
            {
                $form->mail = strip_tags($_POST['User']['mail']);
                $form->password = strip_tags($_POST['User']['password']);

                $number = strip_tags($_POST['User']['phone']);
                $number = preg_replace("/\D/", "", $number);                    //оставляем в телефоне только цифры
                $number = "+".$number;                                          //добавляем +
                $form->phone = $number;

                $form->name = strip_tags($_POST['User']['name']);
                $form->surname = strip_tags($_POST['User']['surname']);
                $form->card = strip_tags($_POST['User']['card']);
                $form->scenario = 'registration';                               //сценарий для валидации

                if (!empty($_POST['code']))                                     //если введен код подтверждения телефона
                {
                    if (md5($_POST['code']) != Yii::app()->session['code'])     //код введен неверно
                    {
                        $model->addError('code', 'Код введен неверно.');        //добавляем ошибку
                    } else
                    {
                        $form->password = md5(strip_tags($_POST['User']['password']));    //записываем пароль в md5
                        $form->role = 'user';                                             //выставляем роль
                        $form->date = new CDbExpression('NOW()');                         //дата регистрации
                        $form->save();                                                    //сохраняем пользователя                  
                        $identity = new UserIdentity($form->mail, $form->password);       //создаем экземляр дял логина
                        $identity->authenticate();                                        //проверка логина, пароля
                        Yii::app()->user->login($identity, 3600 * 24 * 300);              //логинимся (время хранения кук)
                        if (!empty($form->card))
                        {
                            $card = Cards::model()->findByAttributes(array('num' => $form->card));
                            $card->status = "connect";
                            $card->user_id = $form->id;
                            $card->save();
                            var_dump($card->getErrors());
                        }
                        $this->renderPartial("registrationSuccess", array('form' => $form), false, true);
                        exit();
                    }
                }

                if ($form->validate())                                          //валидация данных
                {
                    $form->code = User::model()->generate_code(6);              //генерация кода подтверждения телефона
                    //if (Yii::app()->smspilot->send($form->phone, 'Код проверки телефона: '.$form->code, 'aksenovlook'))   //отправка смс                                                     //если удалось отправить код
                    if (isset($form->code))
                    {
                        var_dump($form->code);
                        $session = Yii::app()->session;                         //открываем сессию
                        $session['code'] = md5($form->code);                    //записываем код в сессию в md5
                        $this->renderPartial("registrationPhone", array('form' => $form), false, true);
                    } else
                    {
                        $form->addError('phone', 'Невозможно отправить код на телефон. Проверьте правильность номера или свяжитесь с администрацией.');
                        $this->renderPartial("registrationError", array('form' => $form), false, true);
                    }
                } else
                    $this->renderPartial("registrationError", array('form' => $form), false, true);
            } else
                $this->renderPartial("registration", array('form' => $form), false, false);
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
