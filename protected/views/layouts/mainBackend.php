<?php /* @var $this Controller */ ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" /> 
        <link rel="stylesheet" type="text/css" href="css/sb-admin.css" /> 
        <link rel="stylesheet" type="text/css" href="css/plugins/morris.css" /> 
        <link rel="stylesheet" type="text/css" href="css/font-awesome-4.1.0/css/font-awesome.min.css" />

        <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script>
        <link rel="shortcut icon" href="images/scrissons.ico" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>

        <div id="wrapper">
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

                <div class="navbar-header">
                    <?php
                    if (Yii::app()->user->role == 'admin')
                        echo '<a class="navbar-brand" href="index.php?r=backend/reservAdmin"><i class="fa fa-fw fa-bars"></i>Личный кабинет</a>';
                    elseif (Yii::app()->user->role == 'user')
                        echo '<a class="navbar-brand" href="index.php?r=backend/reserv"><i class="fa fa-fw fa-bars"></i>Личный кабинет</a>';
                    ?>
                    <a class="navbar-brand" style="margin-left: 30px;" href="<?= Yii::app()->homeUrl ?>"><i class="fa fa-reply-all"></i> вернуться на сайт</a>
                </div>

                <ul class="nav navbar-right top-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                            <?php
                            $user = User::model()->findByPk(Yii::app()->user->id);
                            echo ' '.$user['name'].' '.$user['surname'];
                            ?>
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
<?php echo CHtml::link('<i class="fa fa-fw fa-user"></i>Профиль', array('backend/profile'), array()); ?>
                            </li>
                            <li class="divider"></li>
                            <li>
<?php echo CHtml::link('<i class="fa fa-fw fa-power-off"></i>Выход', array('backend/logout'), array()); ?>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <?php
                    $this->widget('zii.widgets.CMenu', array(
                        'htmlOptions' => array('class' => 'nav navbar-nav side-nav'),
                        'encodeLabel' => false,
                        'items'       => array(
                            //array('label' => '<i class="fa fa-fw fa-home fa-lg"></i> Главная', 'url' => array('/backend/index'), 'visible' => Yii::app()->user->role == 'user'),
                            array('label' => '<i class="fa fa-fw fa-pencil-square-o fa-lg"></i> Online запись', 'url' => array('/backend/reserv'), 'visible' => Yii::app()->user->role == 'user'),
                            array('label' => '<i class="fa fa-fw fa-history fa-lg"></i> История посещений', 'url' => array('/backend/history'), 'visible' => Yii::app()->user->role == 'user'),
                            array('label'          => '<i class="fa fa-fw fa-calendar fa-lg"></i> Бронирование', 'url'            => 'javascript:;', 'visible'        => Yii::app()->user->role == 'admin',
                                'linkOptions'    => array('data-toggle' => 'collapse', 'data-target' => '#reservSetting'),
                                'submenuOptions' => array('class' => 'collapse', 'id' => 'reservSetting'),
                                'items'          => array(
                                    array('label' => '<i class="fa fa-fw fa-pencil-square-o"></i> Запись', 'url' => array('/backend/reservAdmin')),
                                    array('label' => '<i class="fa fa-fw fa-wrench"></i> Настройки', 'url' => array('/backend/reservSetting')))),
                            array('label' => '<i class="fa fa-fw fa-newspaper-o fa-lg"></i> Новости', 'url' => array('/backend/news'), 'visible' => Yii::app()->user->role == 'admin'),
                            array('label' => '<i class="fa fa-fw fa-picture-o fa-lg"></i> Галлерея', 'url' => array('/backend/gallery'), 'visible' => Yii::app()->user->role == 'admin'),
                            array('label' => '<i class="fa fa-fw fa-shopping-cart fa-lg"></i> Магазин', 'url' => array('/backend/shop'), 'visible' => Yii::app()->user->role == 'admin'),
                            array('label' => '<i class="fa fa-fw fa-child fa-lg"></i> Услуги', 'url' => array('/backend/service'), 'visible' => Yii::app()->user->role == 'admin'),
                            array('label' => '<i class="fa fa-fw fa-map-marker fa-lg"></i> Контакты', 'url' => array('/backend/contact'), 'visible' => Yii::app()->user->role == 'admin'),
                            array('label' => '<i class="fa fa-fw fa-credit-card fa-lg"></i> Карты', 'url' => array('/backend/cards'), 'visible' => Yii::app()->user->role == 'admin'),
                            array('label' => '<i class="fa fa-fw fa-users fa-lg"></i> Пользователи', 'url' => array('/backend/usersAdmin'), 'visible' => Yii::app()->user->role == 'admin'),
                            array('label' => '<i class="fa fa-fw fa-desktop fa-lg"></i> Слайдер', 'url' => array('/backend/slider'), 'visible' => Yii::app()->user->role == 'admin'),                            
                        ),
                    ));
                    ?>
                </div>
            </nav>

            <div id="page-wrapper">
                <div class="container-fluid" >
<?php echo $content; ?>
                </div>
            </div>

        </div>


        <script type="text/javascript" src="js/bootstrap.min.js"></script>
<!--        <script type="text/javascript" src="js/plugins/morris/raphael.min.js"></script>
        <script type="text/javascript" src="js/plugins/morris/morris.min.js"></script>
        <script type="text/javascript" src="js/plugins/morris/morris-data.js"></script>-->
    </body>
</html>
