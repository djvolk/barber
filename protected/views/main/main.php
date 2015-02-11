<head>
    <title><?php echo Yii::app()->name; ?></title>
    <meta name="keywords" content="<?php echo Yii::app()->name; ?>"/>
    <meta name="description" content="<?php echo Yii::app()->name; ?>"/>   
</head>    
<style>
    .big {
        font-size: 2.5em;
        line-height: 1;
        margin-bottom: .5em;
        font-family: 'Pompadur';
        font-weight: normal;
        color: #fff;
    }

    .box {
        background: #2c2c2c;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
        position: relative;
        padding: 20px 10px 5px 10px;
        margin-bottom: 25px;
    }

    .want {   
        display:inline;
        width: 100%;
        margin-top:5px;
        background:#009F52;
        color:#ffffff;
        font-family:'Pompadur';
        font-size:22px;
        padding:.4em .8em;
        border:none;
        cursor:pointer;
        -moz-transition:all 200ms linear 0s;
        -webkit-transition:all 200ms linear 0s;
        -o-transition:all 200ms linear 0s;
        transition:all 200ms linear 0s;
    }

    .want:hover {  
        background: #00D66F;		
        color: #fff;
    }


</style>

<div class="home_container">
    <h1>CАЛОН ВАЛЕРИЯ АКСЕНОВА</h1>	
</div><!--/ home_container-->
<div class="content_inner">

    <div class="text-center">
        <p class="big" style="color: #e9403b;">ВНИМАНИЕ АКЦИЯ</p>
    </div>
    <div class="clear"></div>
    <p style="font-size: 18px; font-family:'Pompadur'; color: #fff;">
        ПЕРВЫЙ РАЗ НА САЙТЕ? <br> ЗАРЕГИСТРИРУЙСЯ, ЗАПИШЬ В ЛИЧНОМ КАБИНЕТЕ НА СТРИЖКУ И ПОЛУЧИ СКИДУ 20%.
    </p>

    <div class="clear"></div>
    <div class="content-divider"></div>


    <div class="box text-center" style="margin-top: 80px;">
        <h2 style="font-size: 2.5em;">КАК ЗАПИСАТЬСЯ В САЛОН ?</h2>
    </div>
    <div class="clear"></div>

    <div class="one_half">
        <h3 class="text-center" style="font-size: 18px;">ОСТАВИТЬ БЫСТРУЮ ЗАЯВКУ НА САЙТЕ</h3>
        <p style="font-size: 14px;">
            Вы можете оставить быструю заявку, после чего вам перезвонят в течении часа и назначат время и дату записи. 
        </p>
        <?php
        echo CHtml::button("ХОЧУ БЫСТРУЮ ЗАЯВКУ", array('id' => 'butFast', 'class' => 'want', 'style' => '',));
        ?> 
    </div>
    <div class="one_half_last">
        <h3 class="text-center">ЗАРЕГИСТРИРОВАТЬСЯ И ВЫБРАТЬ ВРЕМЯ</h3>
        <p style="font-size: 14px;">
            Вы можете зарегистрироваться и сами выбрать время и дату для записи в личном кабинете.
        </p>
        <?php
        echo CHtml::button("ХОЧУ ЗАРЕГИСТРИРОВАТЬСЯ", array('id' => 'butReg', 'class' => 'want', 'style' => '',));
        ?> 
    </div>
    <div class="clear"></div>

    
        <div class="box text-center" style="margin-top: 80px;">
        <h2 style="font-size: 2.5em;">МОИ УСЛУГИ</h2>
    </div>
    <div class="clear"></div>
    <p style="font-size: 18px; font-family:'Pompadur';">
        Бла Бла ........ про услуги ...... Бла бла <br>
        Подробнее вы можете узнать на странице 
        <?php echo CHtml::link('Услуги', array(), array('id' => 'linkService', 'style' => 'font-family: "Pompadur"; font-size: 18px; color: #fff;')); ?>
        .
        В 
        <?php echo CHtml::link('Галлерее', array(), array('id' => 'linkGallery', 'style' => 'font-family: "Pompadur"; font-size: 18px; color: #fff;')); ?> 
        вы можете посмотреть работы мастера Валерия Аксенова.
    </p>
    <div class="clear"></div>
    
    
    <div class="text-center" style="margin-top: 80px;">
        <h2 style="font-size: 2.5em;">ОТЗЫВЫ МОИХ КЛИЕНТОВ</h2>
    </div>
    <div class="quoteBox" style="margin-top: 30px;">
        <div class="quote-text">
            Прекрасный мастер, делает замечательные стрижку. Хожу к нему уже несколько лет.
        </div>
        <div class="quote-author">–Анна Пердыщева</div>
    </div>

    <div class="quoteBox" style="margin-top: 30px;">
        <div class="quote-text">

        </div>
        <div class="quote-author">–Amanda Brown</div>
    </div>

    <div class="quoteBox" style="margin-top: 30px;">
        <div class="quote-text">
            Consecetur adipiscing. Donec nunc ipsum, loboris non convallis amet enim. Donec amet orci augue, 
            tristique eros. Nam dui sit amet risus mollis malesuada quis quis nulla. Vestibulum ante 
            ipsum primis faucibus.
        </div>
        <div class="quote-author">–Amanda Brown</div>
    </div>
</div><!--/ content_inner-->
<script type="text/javascript">
    $(document).ready(function () {
        $('.content_inner').jScrollPane();
        setTimeout(function () {
            $('.content_inner').jScrollPane();
        }, 50);

        $("#butReg").click(function () {
            $.ajax({
                type: "POST",
                url: 'registration',
                cache: false,
                success: function (html) {
                    jQuery('#cont').html(html);
                }
            });
            return false;
        });

        $("#linkService").click(function () {
            $.ajax({
                type: "POST",
                url: 'service',
                cache: false,
                success: function (html) {
                    jQuery('#cont').html(html);
                }
            });
            return false;
        });

        $("#linkGallery").click(function () {
            $.ajax({
                type: "POST",
                url: 'gallery',
                cache: false,
                success: function (html) {
                    jQuery('#cont').html(html);
                }
            });
            return false;
        });

    });
</script>