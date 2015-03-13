<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <title><?php echo Yii::app()->name; ?></title>
        <meta name="keywords" content="<?php echo Yii::app()->name.' Стрижка, Окраска, Салон красоты, Парикмахерская, Ножницы, Стричься, Прическа'; ?>"/>
        <meta name="description" content="<?php echo Yii::app()->name.'Мастер Валерий Аксенов. Онлайн запись в салон. Лучшие новые модные срижки. г. Самара, тц. Караван, тел. +79272994406'; ?>"/>  

        <link rel="stylesheet" type="text/css" href="/css/style.css" />
        <link rel="stylesheet" type="text/css" href="/css/font-awesome-4.1.0/css/font-awesome.min.css" />     
        <link rel="stylesheet" type="text/css" href="/css/service.css" />
        <link rel="shortcut icon" href="/images/scrissons.ico" />

        <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script async src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>

    </head>
    <body>
        <div id="background" class="background">
            <?php
            $images_slider = Slider::model()->findAll();
            foreach ($images_slider as $image)
            {
                echo '<img class="bgimage" src="'.Yii::app()->getBaseUrl().'/images/slider/'.$image->image.'" title="'.$image->comment.'" alt="background"/>';
            }
            ?>
            <div class="overlay"></div>
        </div><!--/ background-->

        <div id="pattern" class="pattern"></div>
        <div id="wrapper-panel"> 
            <div class="top-holder">
                <div id="logo">
                    <a title="Салон Валерия Аксенова" href="<?= Yii::app()->homeUrl ?>"><img src="images/logo.png" alt="Салон Валерия Аксенова" title="Салон Валерия Аксенова"></a>
                </div><!--/ logo-->        
            </div><!--/ top-holder-->

            <!-- ***************** - START Navigation - ***************** -->

            <div id="navigation" class="navigation">
                <ul>
                    <!--                    <li><a href="main" id='main' data-speed="1000" data-easing="easeOutBack">Главная</a></li>-->
                    <!--                    <li><a href="news" data-speed="1000" data-easing="easeOutBack">Новости</a></li>-->
                    <li><a href="service" id='service' data-speed="1000" data-easing="easeOutBack">Услуги</a></li>
                    <!--                    <li><a href="gallery" data-speed="1000" data-easing="easeOutBack">Галлерея</a></li>-->
                    <li><a href="shop" data-speed="1000" data-easing="easeOutBack">Магазин</a></li>
                    <li><a href="contact" data-speed="1000" data-easing="easeOutBack">Контакты</a></li>
                    <li><a href="reserv" data-speed="1000" style="border-color: #009F52;" data-easing="easeOutBack">ONLINE ЗАПИСЬ</a></li>

                </ul>
            </div>


            <!-- ***************** - END Navigation - ***************** -->


            <!-- ***************** - START Footer - ***************** --> 

            <?php
            $vkontakte = Contact::model()->findByAttributes(array('field' => 'vkontakte'));
            $facebook = Contact::model()->findByAttributes(array('field' => 'facebook'));
            $youtube = Contact::model()->findByAttributes(array('field' => 'youtube'));
            $instagram = Contact::model()->findByAttributes(array('field' => 'instagram'));
            ?>
            <footer id="footer">
                <ul class="entry-footer">
                    <li>
                        <ul class="social-list">
                            <li class="soc1"><a href="<?= $vkontakte->value ?>"></a></li>
                            <li class="soc2"><a href="<?= $facebook->value ?>"></a></li>
                            <li class="soc3"><a href="<?= $youtube->value ?>"></a></li>
                            <li class="soc4"><a href="<?= $instagram->value ?>"></a></li>
                        </ul>
                    </li>
                    <li>
                        <ul class="copyright">
                            <li>Copyright &copy; <?php echo date('Y'); ?> by Kayda Dmitriy.</li><br/>
                            <li>All Rights Reserved.</li>
                        </ul>
                    </li>
                </ul><!--/ entry-footer-->
            </footer>   

            <!-- ***************** - END Footer - ***************** -->  

        </div><!--/ wrapper-panel-->

        <!-- ***************** - START Login Form - ***************** -->      
        <?php
        if (Yii::app()->user->role == 'user' || Yii::app()->user->role == 'admin')
        {
            echo '<div class="login" id="login">';
            $this->renderPartial('loginGood');
            echo '</div>';
        } else
        {
            $form = new User();
            echo '<div class="login" id="login">';
            $this->renderPartial('login', array('form' => $form), false, true);
            echo '</div>';
        }
        ?>
        <!-- ***************** - END Login Form - ***************** -->

        <?php
//        $form = new User();
//        echo '<div class="login" style="top: 200px;">';
//        $this->renderPartial('loginDemo', array('form' => $form), false, true);
//        echo '</div>';
        ?>
        <!-- ***************** - END Login Form - ***************** -->

        <!-- ***************** - END Login Form - ***************** -->

        <div id="controls-wrapper">
            <div id="slide-info">
                <div class="title-item"></div>
            </div>	
            <div class="direction-box">
                <div class="direction">
                    <div id="next" class="next"></div>
                    <div id="prev" class="prev"></div>	
                    <span class="direction-play">
                        <a href="#" id="play" class="play"></a>
                    </span>
                </div><!--/ -->
            </div><!--/ direction-box-->
        </div><!--/ controls-wrapper-->

        <!-- ***************** - START Content Wrapper - ***************** -->

        <div id="content_wrapper" class="content_wrapper">
            <span class="close"></span>

            <!-- ***************** - START Content - ***************** -->

            <div id="cont" class="content">
                <?php
                echo $content;
                ?>
            </div>

        </div><!--/ content_wrapper--> 
        <script type="text/javascript" src="http://code.jquery.com/ui/1.9.1/jquery-ui.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="/js/general.js"></script>
    </body>
</html>

<script type="text/javascript">
//    $(document).ready(function () {
//    $("#play").addClass('pause').removeClass('play');
//            intervalID = setInterval("$('#next').trigger('click')", 10000);
//        setTimeout(function () {
//            $("#service").click();
//        }, 1000);
//    });
</script>
