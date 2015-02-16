<?php

class BackendController extends Controller {

    public $layout = '//layouts/column2';

    public function filters() {
        return array(
            'accessControl',
            'postOnly + delete',
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(''),
                'users'   => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('Logout', 'Profile', 'Reserv', 'LoadOperation', 'LoadDate', 'UpdateDate',
                    'CancelReserv', 'SaveProfile', 'History'),
                'roles'   => array('user'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(
                    /* новости */ 'News', 'AddNews', 'EditNews', 'DeleteNews',
                    /* галлерея */ 'Gallery', 'GalleryTitleEdit', 'DeleteGallery',
                    /* слайдер */ 'Slider', 'AddSlider', 'EditSlider', 'DeleteSlider',
                    /* магазин */ 'Shop', 'ShopTitleEdit', 'AddCategory', 'EditCategory', 'DeleteCategory', 'AddProduct', 'EditProduct', 'DeleteProduct',
                    /* бронь - настройки */ 'ReservSetting', 'DeleteOperation',
                    /* бронь - админка */ 'reservAdmin', 'UpdateDateAdmin', 'LoadReservAdmin', 'ChangeReservStatus', 'LoadTimeAdmin', 'ReservEdit', 'LoadUser', 'CancelReservAdmin',
                    /* контакты */ 'Contact',
                    /* услуги */ 'Service',
                    /* карты */ 'Cards', 'DeleteCard',
                    /* пользователи */ 'UsersAdmin', 'UserAdmin'),
                'roles'   => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    ///// ----------------------------- NEWS ----------------------------- /////

    public function actionNews() {

        $criteria = new CDbCriteria;
        $criteria->order = 'id DESC';
        $count = News::model()->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);

        $news = News::model()->findAll($criteria);

        if (isset($_POST['AddNews']))
            $this->redirect(array('AddNews'));

        $this->render('news', array(
            'news'  => $news,
            'pages' => $pages,
        ));
    }

    public function actionAddNews() {

        $model = new News;

        if (isset($_POST['Cancel']))
            $this->redirect(array('News'));

        if (isset($_POST['Save']))
        {
            $model->title = $_POST['News']['title'];
            $model->text = $_POST['News']['text'];
            $model->status = $_POST['News']['status'];
            $model->date = new CDbExpression('NOW()');

            if (!empty($_FILES['News']['name']['pic']))
            {
                $model->pic = CUploadedFile::getInstance($model, 'pic');
                $model->pic->saveAs(getcwd().'/images/news/'.$model->pic->name);
            }

            if ($model->save())
                $this->redirect(array('News'));
        }
        $this->render('newsEdit', array(
            'model' => $model,
            'add'   => true,
        ));
    }

    public function actionEditNews($id) {

        $model = News::model()->findByPk($id);

        if (isset($_POST['Cancel']))
            $this->redirect(array('News'));

        if (isset($_POST['Save']))
        {
            $model->title = $_POST['News']['title'];
            $model->text = $_POST['News']['text'];
            $model->status = $_POST['News']['status'];
            $model->date = new CDbExpression('NOW()');

            if (!empty($_FILES['News']['name']['pic']))
            {
                $model->pic = CUploadedFile::getInstance($model, 'pic');
                $model->pic->saveAs(getcwd().'/images/news/'.$model->pic->name);
            }

            if ($model->save())
                $this->redirect(array('News'));
        }
        $this->render('newsEdit', array(
            'model' => $model,
            'edit'  => true,
        ));
    }

    public function actionDeleteNews($id) {
        $model = News::model()->findByPk($id);
        if (!empty($model->pic))
        {
            $filename = getcwd().'/images/news/'.$model->pic;
            if (file_exists($filename))
                unlink($filename);
        }
        $model->delete();
        $this->redirect(array('News'));
    }

    ///// --------------------------- END NEWS --------------------------- /////
    ///// --------------------------- GALLERY ---------------------------- /////

    public function actionGallery() {

        if (isset($_POST['Refresh']))
        {
            $count = $_POST['uploader_count'];
            if ($count > 0)
            {
                for ($i = 0; $i < $count; $i++)
                {
                    if ($_POST['uploader_'.$i.'_status'] == 'done')
                    {
                        $model = new Gallery;
                        $model->image = $_POST['uploader_'.$i.'_name'];
                        $model->date = new CDbExpression('NOW()');
                        $model->save();
                    }
                }
            }
        }

        if (isset($_POST['Cancel']))
        {
            $count = $_POST['uploader_count'];
            if ($count > 0)
            {
                for ($i = 0; $i < $count; $i++)
                {
                    if ($_POST['uploader_'.$i.'_status'] == 'done')
                    {
                        $filename = getcwd().'/images/gallery/photo/'.$_POST['uploader_'.$i.'_name'];
                        if (file_exists($filename))
                            unlink($filename);
                    }
                }
            }
        }

        $criteria = new CDbCriteria;
        $criteria->order = 'id DESC';
        $count = Gallery::model()->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);

        $images = Gallery::model()->findAll($criteria);

        $this->render('gallery', array(
            'images' => $images,
            'pages'  => $pages,
        ));
    }

    public function actionDeleteGallery($id) {
        $model = Gallery::model()->findByPk($id);
        $filename = getcwd().'/images/gallery/photo/'.$model->image;
        if (file_exists($filename))
            unlink($filename);
        $model->delete();
        $this->redirect(array('Gallery'));
    }

    public function actionGalleryTitleEdit() {

        if (isset($_POST['Save']))
        {
            $page = Page::model()->findByAttributes(array('page' => 'gallery'));
            $page->text = $_POST['Page']['text'];
            if ($page->save())
                $this->redirect(array('GalleryTitleEdit'));
        }

        $page = Page::model()->findByAttributes(array('page' => 'gallery'));

        $this->render('page', array(
            'page' => $page,
        ));
    }

    ///// ------------------------- END GALLERY -------------------------- /////
    ///// --------------------------- SLIDER ---------------------------- /////

    public function actionSlider() {

        $criteria = new CDbCriteria;
        $criteria->order = 'id DESC';
        $count = Slider::model()->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);

        $images = Slider::model()->findAll($criteria);

        if (isset($_POST['AddSlider']))
            $this->redirect(array('AddSlider'));

        $this->render('slider', array(
            'images' => $images,
            'pages'  => $pages,
        ));
    }

    public function actionAddSlider() {

        $model = new Slider;

        if (isset($_POST['Cancel']))
            $this->redirect(array('Slider'));

        if (isset($_POST['Save']))
        {
            $model->comment = $_POST['Slider']['comment'];

            if (!empty($_FILES['Slider']['name']['image']))
            {
                $model->image = CUploadedFile::getInstance($model, 'image');
                $model->image->saveAs(getcwd().'/images/slider/'.$model->image->name);
            }

            if ($model->save())
                $this->redirect(array('Slider'));
        }
        $this->render('sliderEdit', array(
            'model' => $model,
            'add'   => true,
        ));
    }

    public function actionEditSlider($id) {

        $model = Slider::model()->findByPk($id);

        if (isset($_POST['Cancel']))
            $this->redirect(array('Slider'));

        if (isset($_POST['Save']))
        {
            $model->comment = $_POST['Slider']['comment'];

            if (!empty($_FILES['Slider']['name']['image']))
            {
                $model->image = CUploadedFile::getInstance($model, 'image');
                $model->image->saveAs(getcwd().'/images/slider/'.$model->image->name);
            }

            if ($model->save())
                $this->redirect(array('Slider'));
        }
        $this->render('sliderEdit', array(
            'model' => $model,
            'edit'  => true,
        ));
    }

    public function actionDeleteSlider($id) {
        $model = Slider::model()->findByPk($id);
        if (!empty($model->image))
        {
            $filename = getcwd().'/images/slider/'.$model->image;
            if (file_exists($filename))
                unlink($filename);
        }
        $model->delete();
        $this->redirect(array('Slider'));
    }

    ///// ------------------------- END SLIDER -------------------------- /////
    ///// --------------------------- SHOP ---------------------------- /////    

    public function actionShop() {

        $criteria = new CDbCriteria;
        $criteria->order = 'id DESC';
        $categories = Category::model()->findAll($criteria);

        if (isset($_GET['id']))
        {
            $category = Category::model()->findByPk($_GET['id']);

            $criteria = new CDbCriteria;
            $criteria->condition = 'category_id = '.$_GET['id'];
            $criteria->order = 'id DESC';

            $count = Product::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 20;
            $pages->applyLimit($criteria);

            $products = Product::model()->findAll($criteria);

            $load = true;
        } else
        {
            $criteria = new CDbCriteria;
            $criteria->order = 'id DESC';

            $count = Product::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 20;
            $pages->applyLimit($criteria);

            $products = Product::model()->findAll($criteria);

            $load = false;
        }

        $this->render('shop', array(
            'categories' => $categories,
            'products'   => $products,
            'pages'      => $pages,
            'category'   => $category,
            'load'       => $load,
        ));
    }

    public function actionAddCategory() {

        $model = new Category;

        if (isset($_POST['Cancel']))
            $this->redirect(array('Shop'));

        if (isset($_POST['Category']))
        {
            $model->name = $_POST['Category']['name'];

            if (!empty($_FILES['Category']['name']['image']))
            {
                $model->image = CUploadedFile::getInstance($model, 'image');
                $model->image->saveAs(getcwd().'/images/shop/category/'.$model->image->name);
            }

            if ($model->save())
                $this->redirect(array('Shop'));
        }
        $this->render('categoryEdit', array(
            'model' => $model,
            'add'   => true,
        ));
    }

    public function actionEditCategory($id) {

        $model = Category::model()->findByPk($id);

        if (isset($_POST['Cancel']))
            $this->redirect(array('Shop'));

        if (isset($_POST['Category']))
        {
            $model->name = $_POST['Category']['name'];

            if (!empty($_FILES['Category']['name']['image']))
            {
                $model->image = CUploadedFile::getInstance($model, 'image');
                $model->image->saveAs(getcwd().'/images/shop/category/'.$model->image->name);
            }

            if ($model->save())
                $this->redirect(array('Shop', 'id' => $model->id));
        }
        $this->render('categoryEdit', array(
            'model' => $model,
            'edit'  => true,
        ));
    }

    public function actionDeleteCategory($id) {
        $model = Category::model()->findByPk($id);
        if (!empty($model->image))
        {
            $filename = getcwd().'/images/shop/category/'.$model->image;
            if (file_exists($filename))
                unlink($filename);
        }
        $model->delete();
        $this->redirect(array('Shop'));
    }

    public function actionAddProduct() {

        $model = new Product;

        if (isset($_POST['Cancel']))
            $this->redirect(array('Shop'));

        if (isset($_POST['Product']))
        {
            $model->category_id = $_POST['Product']['category_id'];
            $model->in_stock = $_POST['Product']['in_stock'];
            $model->title = $_POST['Product']['title'];
            $model->date = new CDbExpression('NOW()');
            $model->description = $_POST['Product']['description'];
            $model->brief_description = $_POST['Product']['brief_description'];
            $model->status = $_POST['Product']['status'];

            if (!empty($_FILES['Product']['name']['image']))
            {
                $model->image = CUploadedFile::getInstance($model, 'image');
                $model->image->saveAs(getcwd().'/images/shop/products/'.$model->image->name);
            }

            if ($model->save())
                $this->redirect(array('Shop'));
        }
        $this->render('productEdit', array(
            'model' => $model,
            'add'   => true,
        ));
    }

    public function actionEditProduct($id) {

        $model = Product::model()->findByPk($id);

        if (isset($_POST['Cancel']))
            $this->redirect(array('Shop'));

        if (isset($_POST['Product']))
        {
            $model->category_id = $_POST['Product']['category_id'];
            $model->in_stock = $_POST['Product']['in_stock'];
            $model->title = $_POST['Product']['title'];
            $model->date = new CDbExpression('NOW()');
            $model->description = $_POST['Product']['description'];
            $model->brief_description = $_POST['Product']['brief_description'];
            $model->status = $_POST['Product']['status'];

            if (!empty($_FILES['Product']['name']['image']))
            {
                $model->image = CUploadedFile::getInstance($model, 'image');
                $model->image->saveAs(getcwd().'/images/shop/products/'.$model->image->name);
            }

            if ($model->save())
                $this->redirect(array('Shop'));
        }
        $this->render('productEdit', array(
            'model' => $model,
            'edit'  => true,
        ));
    }

    public function actionDeleteProduct($id) {
        $model = Product::model()->findByPk($id);
        if (!empty($model->image))
        {
            $filename = getcwd().'/images/shop/products/'.$model->image;
            if (file_exists($filename))
                unlink($filename);
        }        
        $model->delete();
        $this->redirect(array('Shop'));
    }

    public function actionShopTitleEdit() {

        if (isset($_POST['Save']))
        {
            $page = Page::model()->findByAttributes(array('page' => 'shop'));
            $page->text = $_POST['Page']['text'];
            if ($page->save())
                $this->redirect(array('ShopTitleEdit'));
        }

        $page = Page::model()->findByAttributes(array('page' => 'shop'));

        $this->render('page', array(
            'page' => $page,
        ));
    }

    ///// ------------------------- END SHOP -------------------------- /////
    ///// --------------------------- RESERV ---------------------------- /////    

    public function actionReserv() {

        $month = Settings::model()->getMonthName();
        $time = Settings::model()->getTime();

        if (date('H') > $time['end']['H'])                                      //если сегодня уже поздно
            $date['num'] = time() + 86400;                                      //выставляем завтра
        else
            $date['num'] = time();                                                                     //выставляем дату "сегодня"
        $date['string'] = date("j", $date['num']).' '.$month[date("n", $date['num'])];                                         //дата в строку для отображения
        $date['time_start'] = mktime($time['start']['H'], $time['start']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));
        $date['time_end'] = mktime($time['end']['H'], $time['end']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));
        $date['period'] = Settings::model()->getPeriod();

        if (isset($_POST['Confirm']))
        {
            $operation = Operations::model()->findByPk($_POST["operation"]);

            $model = new Reserv;
            $model->user_id = Yii::app()->user->id;
            $model->operation_id = $_POST["operation"];
            $model->time_start = $_POST["time"];
            $model->time_end = $_POST["time"] + (60 * $operation['time']);
            $model->date = $_POST["date"];
            $model->status = 'new';

            if ($model->validate())
            {
                $model->save();

                /* код отправки смс */
                $sms = Settings::model()->getSMSSettings();
                if ($sms['sms'] == 'true')
                {
                    $user = User::model()->findByPk($model->user_id);
                    $text = 'Новая бронь: '.$user->name.' '.$user->surname.' '.$user->phone.' '.$operation->name.' '.date("H:i d.m", $model->time_start);
                    Yii::app()->smspilot->send($sms['sms_phone'], $text, 'aksenovlook');
                }
                /* ---------------- */

                $this->redirect(array('Reserv'));
            } else
                $error = $model->getErrors();
        }

        if (isset($_POST['Cancel']))
        {
            $reserv = Reserv::model()->findByPk($_POST['id']);

            $reserv->comment = $_POST['reason'];
            $reserv->status = 'bad_by_user';                                    //меняем статус на отказанный
            $reserv->save();

            /* код отправки смс - отправляем смс с причиной отказа */
            $sms = Settings::model()->getSMSSettings();
            if ($sms['sms'] == 'true')
            {
                $operation = Operations::model()->findByPk($reserv->operation_id);
                $user = User::model()->findByPk($reserv->user_id);
                $text = 'Отмена брони: '.$user->name.' '.$user->surname.' '.$user->phone.' '.$operation->name.' '.date("H:i d.m", $reserv->time_start);
                Yii::app()->smspilot->send($sms['sms_phone'], $text, 'aksenovlook');
            }
            /* ---------------- */

            $this->redirect(array('Reserv'));
        }

        $criteria = new CDbCriteria;
        $criteria->condition = 'date = "'.date("d-m-Y", $date['num']).'"';
        $reserved = Reserv::model()->findAll($criteria);

        $user_reserv = Reserv::model()->getUserReserv();                        //информация о брони пользователя
        $this->render('reserv', array(
            'date'        => $date,
            'user_reserv' => $user_reserv,
            'reserved'    => $reserved,
            'error'       => $error,
        ));
    }

//страница бронирования для пользователя

    public function actionUpdateDate() {

        $month = Settings::model()->getMonthName();
        $time = Settings::model()->getTime();
        $date['period'] = Settings::model()->getPeriod();

        $date['num'] = strtotime($_POST['date']);                                               //выставляем выбранную дату
        $date['string'] = date("j", $date['num']).' '.$month[date("n", $date['num'])];          //дата в строку для отображения

        $date['time_start'] = mktime($time['start']['H'], $time['start']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));
        $date['time_end'] = mktime($time['end']['H'], $time['end']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));

        $criteria = new CDbCriteria;
        $criteria->condition = 'date = "'.date("d-m-Y", $date['num']).'"';
        $reserved = Reserv::model()->findAll($criteria);

        $this->renderPartial('_reserv', array('date' => $date, 'reserved' => $reserved), false, true);
    }

//обновление календаря

    public function actionLoadOperation() {

        if (!empty($_POST['operation']))
        {
            $user = User::model()->findByPk(Yii::app()->user->id);
            $model = Operations::model()->findByPk($_POST['operation']);
            echo '<blockquote class="text-success" style="font-size: 16pt;"><p>'.$model->name.'</p></blockquote>';
            echo 'Примерная длительность: <strong>'.$model->time.' минут</strong><br>';
            echo 'Примерная цена: <strong>'.$model->price.' рублей </strong><br>';
            if (!empty($user['card']))
                echo 'Примерная цена (по карте): <strong>'.$model->discount_price.' рублей </strong><br>';
            echo '<h3><em><small>'.$model->comment.'</small></em></h3>';
            echo '<input type="hidden" id="operation_success" value="true" >';
        } else
        {
            echo '<h2><em><small>Выберите услугу</small></em></h2>';
        }
    }

//отображение результата выбора пользователем услуги

    public function actionLoadDate() {

        $month = Settings::model()->getMonthName();
        echo 'Когда: <strong>'.date("j", $_POST['time']).' '.$month[date("n", $_POST['time'])].'</strong><br>';
        echo 'Время: <strong>'.date("H:i", $_POST['time']).'</strong><br>';
        echo '<input type="hidden" id="date_success" value="true" >';
        echo '<input type="hidden" name="time" value="'.$_POST['time'].'" >';
    }

//отображение результата выбора пользователем даты и времени

    public function actionLoadUser() {

        if (!empty($_POST['user']))
        {
            $user = User::model()->findByPk($_POST['user']);
            echo CHtml::link('<h4>'.$user['surname'].' '.$user['name'], array('backend/ProfileAdmin', 'id' => $user['id']), array('style' => ''));
            echo '<span style="float:right;">'.$user['phone'].'</span></h4>';
            echo '<input type="hidden" id="user_success" value="true" >';
        } else
        {
            echo '<h2><em><small>Выберите пользователя</small></em></h2>';
        }
    }

//отображение результата выбора алмином пользователя

    public function actionCancelReserv() {

        echo '<input type="hidden" value="'.$_POST['id'].'" name="id">';
        echo CHtml::textArea('reason', '', array('class' => 'form-control', 'style' => 'resize:none;', 'rows' => 3, 'id' => 'reason', 'placeholder' => 'Введите причину отказа'));
        echo CHtml::submitButton('Отменить запись', array('name' => 'Cancel', 'class' => 'btn btn-danger', 'style' => 'float:right; margin-top:10px;'));
    }

//отмена записи пользователем    

    public function actionReservAdmin() {

        $month = Settings::model()->getMonthName();                             //массив названий месяцев
        $time = Settings::model()->getTime();                                   //время начала и конца рабочего дня

        if (date('H') > $time['end']['H'])                                      //если сегодня уже поздно
            $date['num'] = time() + 86400;                                      //выставляем завтра
        else
            $date['num'] = time();                                                                     //выставляем дату "сегодня"
        $date['string'] = date("j", $date['num']).' '.$month[date("n", $date['num'])];                                         //дата в строку для отображения
        $date['time_start'] = mktime($time['start']['H'], $time['start']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));
        $date['time_end'] = mktime($time['end']['H'], $time['end']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));
        $date['period'] = Settings::model()->getPeriod();


        $criteria = new CDbCriteria;
        $criteria->condition = 'date = "'.date("d-m-Y", $date['num']).'"';
        $reserved = Reserv::model()->findAll($criteria);                        //массив всех броней на данный день

        $new_reserved = Reserv::model()->getReserv('"new"');                    //новые записи
        $bad_reserved = Reserv::model()->getReserv('"bad_by_user"');            //записи отмененные пользователем
        $this->render('reservAdmin', array(
            'date'         => $date,
            'new_reserved' => $new_reserved,
            'bad_reserved' => $bad_reserved,
            'reserved'     => $reserved,
        ));
    }

//страница бронирования для админа

    public function actionLoadReservAdmin() {

        $item = Reserv::model()->getReservItem($_POST['id']);
        echo '<div class="panel-heading">';
        echo '<h3 class="panel-title"><strong>'.$item['date'].' '.$item['start'].'</strong></h3>';
        echo '</div>';

        echo '<div class="panel-body">';
        echo '<div class="form-group">';
        echo CHtml::link('<h4>'.$item['surname'].' '.$item['firstname'], array('backend/UserAdmin', 'id' => $item['user_id']), array('style' => ''));
        if (!empty($item['card']))
            echo '<i class="fa fa-fw fa-credit-card fa-lg" style="margin-left:30px;"></i>';
        echo '<span style="float:right;">'.$item['phone'].'</span></h4>';

        echo '<h4>'.$item['name'].'</h4>';
        echo 'Время: <strong>'.$item['start'].' - '.$item['end'].'</strong><br>';
        echo 'Примерная длительность: <strong>'.$item['duration'].' минут</strong><br>';
        echo 'Примерная цена: <strong>'.$item['price'].' рублей</strong><br>';
        echo 'Примерная цена (по карте): <strong>'.$item['discount_price'].' рублей</strong><br><br>';

        if ($item['status'] == 'bad_by_user')
        {
            echo 'Причина: <strong>'.$item['comment'].'</strong>';
            $reserv = Reserv::model()->findByPk($item['id']);
            $reserv->status = 'bad';                                            //меняем статус на отказанный
            $reserv->save();
        } else
        {
            echo '<div id="button">';
            echo CHtml::link('Подтвердить', array('backend/ChangeReservStatus', 'id' => $item['id'], 'status' => 'reserved'), array('class' => 'btn btn-success', 'style' => 'float:right; margin-left:10px;'));
            echo CHtml::link('Изменить', array('backend/ReservEdit', 'id' => $item['id']), array('class' => 'btn btn-warning', 'style' => 'float:right; margin-left:10px;'));
            echo CHtml::link('Отменить', '', array('id' => $item['id'], 'onclick' => 'cancel_click('.$item['id'].');', 'class' => 'btn btn-danger cancel', 'style' => 'float:right;'));
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    }

//загрузка подробностей о записи на бронирование

    public function actionLoadTimeAdmin() {

        $month = Settings::model()->getMonthName();
        $date = date("j", $_POST['time']).' '.$month[date("n", $_POST['time'])];
        $time = date("H:i", $_POST['time']);

        if ((int) ($_POST['id']) > 0)
        {
            $item = Reserv::model()->getReservItem($_POST['id']);

            if ($item['status'] == 'blocked')
            {
                echo '<div class="panel-heading">';
                echo '<h3 class="panel-title"><strong>'.$date.' '.$time.'</strong></h3>';
                echo '</div>';

                echo '<div class="panel-body">';
                echo '<div class="form-group">';

                echo CHtml::link('Разблокировать время', array('backend/ChangeReservStatus', 'id' => $_POST['id'], 'status' => 'unblock'), array('class' => 'btn btn-success', 'style' => 'float:right;'));

                echo '</div>';
                echo '</div>';
            } else
            {
                echo '<div class="panel-heading">';
                echo '<h3 class="panel-title"><strong>'.$date.' '.$time.'</strong></h3>';
                echo '</div>';

                echo '<div class="panel-body">';
                echo '<div class="form-group">';
                echo CHtml::link('<h4>'.$item['surname'].' '.$item['firstname'], array('backend/UserAdmin', 'id' => $item['user_id']), array('style' => ''));
                if (!empty($item['card']))
                    echo '<i class="fa fa-fw fa-credit-card fa-lg" style="margin-left:30px;"></i>';
                echo '<span style="float:right;">'.$item['phone'].'</span></h4>';

                echo '<h4>'.$item['name'].'</h4>';
                echo 'Время: <strong>'.$item['start'].' - '.$item['end'].'</strong><br>';
                echo 'Примерная длительность: <strong>'.$item['duration'].' минут</strong><br>';
                echo 'Примерная цена: <strong>'.$item['price'].' рублей</strong><br>';
                echo 'Примерная цена (по карте): <strong>'.$item['discount_price'].' рублей</strong><br><br>';

                echo '<div id="button">';
                if ($item['status'] == 'new')
                    echo CHtml::link('Подтвердить', array('backend/ChangeReservStatus', 'id' => $item['id'], 'status' => 'reserved'), array('class' => 'btn btn-success', 'style' => 'float:right; margin-left:10px;'));
                echo CHtml::link('Изменить', array('backend/ReservEdit', 'id' => $item['id']), array('class' => 'btn btn-warning', 'style' => 'float:right; margin-left:10px;'));
                echo CHtml::link('Отменить', '', array('id' => $item['id'], 'onclick' => 'cancel_click('.$item['id'].');', 'class' => 'btn btn-danger cancel', 'style' => 'float:right;'));
                echo '</div>';

                echo '</div>';
                echo '</div>';
            }
        } elseif ($_POST['id'] == 'clear')
        {
            echo '<div class="panel-heading">';
            echo '<h3 class="panel-title"><strong>'.$date.' '.$time.'</strong></h3>';
            echo '</div>';

            echo '<div class="panel-body">';
            echo '<div class="form-group">';

            echo CHtml::link('Заблокировать время', array('backend/ChangeReservStatus', 'id' => $_POST['time'], 'status' => 'blocked'), array('class' => 'btn btn-danger', 'style' => 'float:right;'));

            echo '</div>';
            echo '</div>';
        }
    }

//загрузка подробностей о ячейки времени 

    public function actionChangeReservStatus($id, $status) {

        if ($status == 'reserved')                                              //подтвердить запись
        {
            $reserv = Reserv::model()->findByPk($id);
            $reserv->status = $status;
            $reserv->save();

            /* код отправки смс - подтверждаем запись */
            $sms = Settings::model()->getSMSSettings();
            if ($sms['sms'] == 'true')
            {
                $operation = Operations::model()->findByPk($reserv->operation_id);
                $user = User::model()->findByPk($reserv->user_id);
                $text = 'Ваша запись на '.date("H:i d.m", $reserv->time_start).' ('.$operation->name.') ПОДТВЕРЖДЕНА';
                Yii::app()->smspilot->send($user['phone'], $text, 'aksenovlook');
            }
            /* ---------------- */

            $this->redirect(array('ReservAdmin'));
        } elseif ($status == 'blocked')                                         //заблокировать время
        {
            $model = new Reserv;
            $model->user_id = Yii::app()->user->id;
            $model->operation_id = 0;
            $model->time_start = $id;
            $model->time_end = $id + Settings::model()->getPeriod();
            $model->date = date("d-m-Y", $id);
            $model->status = 'blocked';

            if ($model->save())
                $this->redirect(array('ReservAdmin'));
        } elseif ($status == 'unblock')                                         //разблокировать время
        {
            $model = Reserv::model()->findByPk($id);
            $model->delete();
            $this->redirect(array('ReservAdmin'));
        } elseif ($status == 'bad')                                             //разблокировать время
        {
            $model = Reserv::model()->findByPk($id);
            $model->delete();
            $this->redirect(array('ReservAdmin'));
        }
    }

//смена статуса записи

    public function actionUpdateDateAdmin() {

        $month = Settings::model()->getMonthName();
        $time = Settings::model()->getTime();
        $date['period'] = Settings::model()->getPeriod();

        $date['num'] = strtotime($_POST['date']);                                               //выставляем выбранную дату
        $date['string'] = date("j", $date['num']).' '.$month[date("n", $date['num'])];          //дата в строку для отображения

        $date['time_start'] = mktime($time['start']['H'], $time['start']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));
        $date['time_end'] = mktime($time['end']['H'], $time['end']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));

        $criteria = new CDbCriteria;
        $criteria->condition = 'date = "'.date("d-m-Y", $date['num']).'"';
        $reserved = Reserv::model()->findAll($criteria);

        $this->renderPartial('_reservAdmin', array('date' => $date, 'reserved' => $reserved), false, true);
    }

//обновление календаря (страница админа) 

    public function actionReservEdit() {

        $month = Settings::model()->getMonthName();
        $time = Settings::model()->getTime();
        $date['period'] = Settings::model()->getPeriod();

        if (isset($_GET['id']))
        {
            $item = Reserv::model()->getReservItem($_GET['id']);
            $date['num'] = $item['time_start'];                                 //выставляем дату загруженной записи
            $date['string'] = date("j", $date['num']).' '.$month[date("n", $date['num'])];          //дата в строку для отображения
            $date['time_start'] = mktime($time['start']['H'], $time['start']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));
            $date['time_end'] = mktime($time['end']['H'], $time['end']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));
        } else
        {
            if (date('H') > $time['end']['H'])                                      //если сегодня уже поздно
                $date['num'] = time() + 86400;                                      //выставляем завтра
            else
                $date['num'] = time();                                                                     //выставляем дату "сегодня"
            $date['string'] = date("j", $date['num']).' '.$month[date("n", $date['num'])];                                         //дата в строку для отображения
            $date['time_start'] = mktime($time['start']['H'], $time['start']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));
            $date['time_end'] = mktime($time['end']['H'], $time['end']['i'], 0, date("m", $date['num']), date("d", $date['num']), date("Y", $date['num']));
        }

        if (isset($_POST['Confirm']))
        {
            $operation = Operations::model()->findByPk($_POST["operation"]);

            $model = new Reserv;
            $model->user_id = $_POST["user"];
            $model->operation_id = $_POST["operation"];
            $model->time_start = $_POST["time"];
            $model->time_end = $_POST["time"] + (60 * $operation['time']);
            $model->date = $_POST["date"];
            $model->status = 'reserved';

            if (!$model->save())
                $message = 'Упс, произошла ошибка. Пожалуйста, свяжитесь с администрацией сайта.';
            else
            {
                /* код отправки смс - создаем запись */
                $sms = Settings::model()->getSMSSettings();
                if ($sms['sms'] == 'true')
                {
                    $operation = Operations::model()->findByPk($model->operation_id);
                    $user = User::model()->findByPk($model->user_id);
                    $text = 'Вас записали на '.date("H:i d.m", $model->time_start).' ('.$operation->name.')';
                    Yii::app()->smspilot->send($user['phone'], $text, 'aksenovlook');
                }
                /* ---------------- */
                $this->redirect(array('ReservAdmin'));
            }
        }

        if (isset($_POST['Save']))
        {
            $operation = Operations::model()->findByPk($_POST["operation"]);

            $model = Reserv::model()->findByPk($_GET['id']);

            $old_time = $model->time_start;
            $old_operation_id = $model->operation_id;

            $model->user_id = $_POST["user"];
            $model->operation_id = $_POST["operation"];
            $model->time_start = $_POST["time"];
            $model->time_end = $_POST["time"] + (60 * $operation['time']);
            $model->date = $_POST["date"];
            $model->status = 'reserved';

            if (!$model->save())
                $message = 'Упс, произошла ошибка. Пожалуйста, свяжитесь с администрацией сайта.';
            else
            {
                /* код отправки смс - изменяем запись */
                $sms = Settings::model()->getSMSSettings();
                if ($sms['sms'] == 'true')
                {
                    $old_operation = Operations::model()->findByPk($old_operation_id);
                    $operation = Operations::model()->findByPk($model->operation_id);
                    $user = User::model()->findByPk($model->user_id);
                    $text = 'Ваша запись на '.date("H:i d.m", $old_time).' ('.$old_operation->name.') ИЗМЕНЕНА ('.date("H:i d.m", $model->time_start).' '.$operation->name.')';
                    Yii::app()->smspilot->send($user['phone'], $text, 'aksenovlook');
                }
                /* ---------------- */
                $this->redirect(array('ReservAdmin'));
            }
        }

        $criteria = new CDbCriteria;
        $criteria->condition = 'date = "'.date("d-m-Y", $date['num']).'"';
        $reserved = Reserv::model()->findAll($criteria);

        $this->render('reservEdit', array(
            'date'     => $date,
            'item'     => $item,
            'reserved' => $reserved,
        ));
    }

//редактирование и создание записи админом    

    public function actionCancelReservAdmin() {
        if (isset($_POST['Cancel']))
        {
            $reserv = Reserv::model()->findByPk($_POST['id']);

            if (isset($_POST['sms_checkbox']))                                  //отправляем смс с причиной отказа
            {
                $user = User::model()->findByPk($reserv->user_id);
                /* код отправки смс - подтверждаем запись */
                $sms = Settings::model()->getSMSSettings();
                if ($sms['sms'] == 'true')
                {
                    $operation = Operations::model()->findByPk($reserv->operation_id);
                    $user = User::model()->findByPk($reserv->user_id);
                    $text = 'Ваша запись на '.date("H:i d.m", $reserv->time_start).' ('.$operation->name.') ОТМЕНА ('.$_POST['sms'].')';
                    Yii::app()->smspilot->send($user['phone'], $text, 'aksenovlook');
                }
                /* ---------------- */
            }

            $reserv->status = 'bad';                                            //меняем статус на отказанный
            $reserv->save();
            $this->redirect(array('ReservAdmin'));
        } else
            $this->renderPartial('_cancelReservAdmin', array('id' => $_POST['id'])); //загружаем форму отказа
    }

//отмена записи админом    

    public function actionReservSetting() {

        $model = new Operations();

        $operations = new CDbCriteria;
        $operations->order = 'id DESC';
        $operations = Operations::model()->findAll($criteria);

        if (isset($_POST['saveReport']))
        {
            $field = Settings::model()->findByAttributes(array('field' => 'sms_phone'));
            $field->value = $_POST['sms_phone'];
            $field->save();

            $field = Settings::model()->findByAttributes(array('field' => 'mail'));
            $field->value = $_POST['mail'];
            $field->save();

            $field = Settings::model()->findByAttributes(array('field' => 'sms'));
            if ($_POST['sms'])
                $field->value = $_POST['sms'];
            else
                $field->value = 'false';
            $field->save();
        }

        if (isset($_POST['saveTime']))
        {
            $criteria = new CDbCriteria;
            $result = Settings::model()->findAll($criteria);

            foreach ($result as $row)
            {
                $field = Settings::model()->findByAttributes(array('field' => $row['field']));
                $field->value = $_POST[$row['field']];
                $field->save();
            }
        }

        $settings = Settings::model()->getSettings();

        if (Yii::app()->request->isAjaxRequest)
        {
            $model->name = $_POST['name'];
            $model->time = $_POST['time'];
            $model->price = $_POST['price'];
            $model->discount_price = $_POST['discount_price'];
            $model->comment = $_POST['comment'];

            if ($model->save())
            {
                echo CJSON::encode(array('status' => 'success'));
            } else
            {
                echo CJSON::encode(array(
                    'status' => 'failure',
                    'div'    => $this->renderPartial('_operation', array(
                        'model' => $model,
                            ), true)));
            }
        } else
            $this->render('reservSetting', array(
                'model'      => $model,
                'operations' => $operations,
                'settings'   => $settings,
            ));
    }

//настройки бронирования для админа

    public function actionDeleteOperation($id) {
        $model = Operations::model()->findByPk($id);
        $model->delete();
        $this->redirect(array('ReservSetting'));
    }

//удаление услуги
    ///// ------------------------- END RESERV -------------------------- /////
    ///// --------------------------- HISTORY --------------------------- /////    

    public function actionHistory() {

        $this->render('history', array(
            'page' => $page,
        ));
    }

//настрока страницы "Услуги"
    ///// ------------------------- END HISTORY ------------------------- /////    
    ///// --------------------------- SERVICE --------------------------- /////    

    public function actionService() {

        if (isset($_POST['Save']))
        {
            $service = Page::model()->findByAttributes(array('page' => 'service'));
            $service->text = $_POST['service'];
            $service->save();
            
            $reviews = Page::model()->findByAttributes(array('page' => 'reviews'));
            $reviews->text = $_POST['reviews'];
            $reviews->save();            
            
            $this->redirect(array('Service'));
        }

        $service = Page::model()->findByAttributes(array('page' => 'service'));
        $reviews = Page::model()->findByAttributes(array('page' => 'reviews'));

        $this->render('service', array(
            'service' => $service,
            'reviews' => $reviews,
        ));
    }

//настрока страницы "Услуги"
    ///// ------------------------- END SERVICE ------------------------- /////
    ///// --------------------------- CONTACT --------------------------- /////    

    public function actionContact() {

        if (isset($_POST['Save']))
        {
            $criteria = new CDbCriteria;
            $result = Contact::model()->findAll($criteria);

            foreach ($result as $row)
            {
                $field = Contact::model()->findByAttributes(array('field' => $row['field']));
                if (!empty($_POST[$row['field']]))
                    $field->value = $_POST[$row['field']];
                else
                    $field->value = '';
                $field->save();
            }
        }

        $contact = Contact::model()->getContact();

        $this->render('contact', array(
            'contact' => $contact,
        ));
    }

//страница настройки контактов админа
    ///// ------------------------- END CONTACT ------------------------- /////
    ///// --------------------------- PROFILE --------------------------- /////

    public function actionProfile() {
        $model = User::model()->findByPk(Yii::app()->user->id);

        if (isset($_POST['SaveInfo']))
        {
            $model->name = strip_tags($_POST['name']);
            $model->surname = strip_tags($_POST['surname']);
            $model->mail = strip_tags($_POST['mail']);
            if ($model->id != 1 AND $model->id != 2)
            {
                if ($model->save())
                    $this->redirect(array('Profile'));
            } else
            {
                $model->addError('name', 'Это демо профиль, Вы не можете изменить это поле.');
                $model->addError('surname', 'Это демо профиль, Вы не можете изменить это поле.');
                $model->addError('mail', 'Это демо профиль, Вы не можете изменить это поле.');
            }
        }

        if (isset($_POST['SaveCard']))
        {
            $model->card = strip_tags($_POST['card']);
            if ($model->save())
                $this->redirect(array('Profile'));
        }

        $this->render('profile', array(
            'model' => $model,
        ));
    }

//страница профиля, изменения имени, mail, карты

    public function actionSaveProfile() {

        $model = User::model()->findByPk(Yii::app()->user->id);

        if (isset($_POST['new_password']))                                      //если изменяют пароль
        {
            //обработка различных ошибок
            if (md5($_POST['old_password']) != $model->password)
                $model->addError('old_password', 'Текущий пароль не верный.');
            if (empty($_POST['old_password']))
                $model->addError('old_password', 'Введите текущий пароль.');
            if ($_POST['new_password'] != $_POST['new_password2'])
                $model->addError('new_password', 'Пароли не совпадают.');
            if (empty($_POST['new_password']) || empty($_POST['new_password2']))
                $model->addError('new_password', 'Введите новый пароль.');

            if ($model->id == 1 OR $model->id == 2)
            {
                $model->addError('old_password', 'Это демо профиль, Вы не можете изменить это поле.');
            }

            if (!$model->hasErrors())                                           //если нет ошибок
            {
                $model->password = md5(strip_tags(($_POST['new_password'])));
                if ($model->save())
                {
                    echo '<div class="alert alert-success">';
                    echo '<strong>Пароль успешно изменен.</strong>';
                    echo '</div>';
                }
            } else
            {
                echo'<label>Введите текущий пароль: </label>';
                echo CHtml::error($model, 'old_password', array('class' => 'alert alert-danger', 'style' => 'margin-top:10px;'));
                echo Chtml::passwordField('old_password', $_POST['old_password'], array('class' => 'form-control',));
                echo CHtml::error($model, 'new_password', array('class' => 'alert alert-danger', 'style' => 'margin-top:10px;'));
                echo CHtml::error($model, 'password', array('class' => 'alert alert-danger', 'style' => 'margin-top:10px;'));
                echo'<label>Введите новый пароль: </label>';
                echo CHtml::textField('new_password', $_POST['new_password'], array('class' => 'form-control'));
                echo'<label>Повторите ввод: </label>';
                echo CHtml::textField('new_password2', $_POST['new_password2'], array('class' => 'form-control'));
                echo CHtml::button('Изменить пароль', array('id' => 'savePassword', 'onclick' => 'savePass();', 'class' => 'btn btn-success', 'style' => 'float:right; margin-top:10px;'));
            }
        }

        if (isset($_POST['phone']) && $_POST['phone'] != $model->phone)
        {
            if (!empty($_POST['code']))                                         //если введен код
            {
                if ($_POST['code'] != $model->code)                             //код введен неверно
                {
                    $model->addError('code', 'Код введен неверно.');

                    echo CHtml::textField('phone', $_POST['phone'], array('class' => 'form-control', 'readonly' => 'readonly', 'style' => 'margin-bottom:10px;'));
                    echo '<label>Код: </label>';
                    echo CHtml::error($model, 'code', array('class' => 'alert alert-danger', 'style' => 'margin-top:10px;'));
                    echo CHtml::textField('code', '', array('class' => 'form-control',));
                    exit();
                } else                                                          //код введен верно
                {
                    $model->code = '';                                          //ощищаем код в базе
                    $model->phone = $_POST['phone'];                            //записываем новый телефон
                    if ($model->save())
                    {
                        echo CHtml::textField('phone', $model['phone'], array('class' => 'form-control', 'style' => 'margin-bottom:10px;'));
                        echo '<div class="alert alert-success">';
                        echo '<strong>Телефон успешно изменен.</strong>';
                        echo '</div>';
                        exit();
                    }
                }
            }

            $phone = strip_tags($_POST['phone']);
            $phone = preg_replace("/\D/", "", $phone);
            $phone = "+".$phone;
            $code = User::model()->generate_code(6);

            if (Yii::app()->smspilot->send($phone, 'Код проверки телефона: '.$code, 'aksenovlook'))                                                        //если удалось отправить код
            {
                $model->code = $code;
                if ($model->save())
                {
                    echo CHtml::textField('phone', $_POST['phone'], array('class' => 'form-control', 'readonly' => 'readonly', 'style' => 'margin-bottom:10px;'));
                    echo '<label>Код: </label>';
                    echo CHtml::textField('code', '', array('class' => 'form-control',));
                }
            } else                                                            //если код не отправлен
            {
                $model->addError('phone', 'Невозможно отправить код на телефон. Проверьте правильность номера или свяжитесь с администрацией.');
                echo CHtml::error($model, 'phone', array('class' => 'alert alert-danger', 'style' => 'margin-top:10px;'));
                echo CHtml::textField('phone', $_POST['phone'], array('class' => 'form-control', 'style' => 'margin-bottom:10px;'));
            }
        }
    }

//изменение пароля и телефона

    public function actionLogout() {

        Yii::app()->user->logout();
        $this->redirect(Yii::app()->createUrl('main/index'));
    }

//выход

    public function actionUsersAdmin() {

        $criteria = new CDbCriteria;
        //$criteria->condition = 'role = "user"';
        $criteria->order = 'surname ASC';
        $count = User::model()->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = 30;
        $pages->applyLimit($criteria);

        $users = User::model()->findAll($criteria);


        $this->render('usersAdmin', array(
            'users' => $users,
        ));
    }

//страница "Пользователи"

    public function actionUserAdmin($id) {
        $model = User::model()->findByPk($id);

        if (isset($_POST['SaveInfo']))
        {
            $model->name = strip_tags($_POST['name']);
            $model->surname = strip_tags($_POST['surname']);
            $model->mail = strip_tags($_POST['mail']);
            if ($model->save())
                $this->redirect(array('Profile'));
        }

        $this->render('userAdmin', array(
            'model' => $model,
        ));
    }

//страница профиля пользователя для Админа    
    ///// ------------------------- END PROFILE ------------------------- /////
    ///// --------------------------- CARDS --------------------------- /////

    public function actionCards() {

        $model = new Cards;
        if (isset($_POST['addCard']))
        {
            $model->num = $_POST['num'];
            $model->user_id = $_POST['user_id'];
            $model->status = $_POST['status'];
            if ($model->save())
                if ($model->user_id != '')
                {
                    $user = User::model()->findByPk($model->user_id);
                    $user->card = $model->num;
                    $user->save();
                    $this->redirect(array('Cards'));
                }
        }

        $criteria = new CDbCriteria;
        $criteria->condition = 'role = "user" AND card = ""';
        $users = User::model()->findAll($criteria);

        $criteria = new CDbCriteria;
        $criteria->order = 'id DESC';
        $count = Cards::model()->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = 30;
        $pages->applyLimit($criteria);

        $cards = Cards::model()->findAll($criteria);

        $this->render('cards', array(
            'model' => $model,
            'cards' => $cards,
            'users' => $users,
        ));
    }

//страница с картами

    public function actionDeleteCard($id) {
        $model = Cards::model()->findByPk($id);
        if ($model->user_id != '')
        {
            $user = User::model()->findByPk($model->user_id);
            $user->card = '';
            $user->save();
        }
        $model->delete();
        $this->redirect(array('Cards'));
    }

//удаление карты
    ///// ------------------------- END CARDS ------------------------- /////    

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
