<title><?php echo 'Услуги - '.Yii::app()->name; ?></title>
<meta name="keywords" content="<?php echo 'Услуги - '.Yii::app()->name; ?>"/>
<meta name="description" content="<?php echo 'Услуги - '.Yii::app()->name; ?>"/>  

<link rel="stylesheet" href="/js/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/js/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>       

<div class="home_container">
    <h1>УСЛУГИ CАЛОНА ВАЛЕРИЯ АКСЕНОВА</h1>	
</div><!--/ home_container-->
<div class="content_inner">

    <!--    <div class="text-center">
            <p class="big" style="color: #e9403b;">ВНИМАНИЕ АКЦИЯ</p>
        </div>
        <div class="clear"></div>
        <p style="font-size: 18px; font-family:'Pompadur'; color: #fff;">
            ПЕРВЫЙ РАЗ НА САЙТЕ? <br> ЗАРЕГИСТРИРУЙСЯ, ЗАПИШЬ В ЛИЧНОМ КАБИНЕТЕ НА СТРИЖКУ И ПОЛУЧИ СКИДУ 20%.
        </p>
    
        <div class="clear"></div>
        <div class="content-divider"></div>-->
    <div class="one_third">
        <img width="180" src="/images/master.jpg" alt="Валерий Аксенов" />
    </div>

    <div class="one_third" style="width:360px;">
        <div class="text-center">
            <h2 style="font-size: 2.5em;">ОБО МНЕ</h2>
        </div>
    </div>

    <div class="clear" style="margin-bottom: 20px;"></div>
    <div class="box text-center">
        <h2 style="font-size: 2.5em;">МОИ УСЛУГИ</h2>
    </div>
    <div class="clear"></div>
    <?= $service->text ?>
    <div class="clear" style="margin-bottom: 80px;"></div>


    <div class="text-center">
        <h2 style="font-size: 2.5em;">ГАЛЛЕРЕЯ МОИХ РАБОТ</h2>
    </div>
    <div class="gl_col_3" id="gallery" style="margin-top: 40px;">
        <?php
        if (isset($images))
            foreach ($images as $image)
            {
                ?>
                <a class="fancybox" rel="gallery1" href="/images/gallery/<?= $image['image'] ?>" title="<?= strip_tags($image['comment']) ?>">
                    <img src="/images/gallery/<?= $image['image'] ?>" alt="<?= $image['alt'] ?>"  height="100" />
                </a>
            <?php } ?>	
    </div>
    <div class="clear" style="margin-bottom: 80px;"></div>

    <div class="text-center">
        <h2 style="font-size: 2.5em;">ОТЗЫВЫ МОИХ КЛИЕНТОВ</h2>
    </div>
    <?= $reviews->text ?>

</div><!--/ content_inner-->
<script type="text/javascript">
    $(document).ready(function () {
        $('.content_wrapper').height(2000);
        $('.fancybox').fancybox({
            'overlayShow': true,
            'transitionIn': 'elastic',
            'transitionOut': 'elastic'
        });

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

        $("#online").click(function () {
            $.ajax({
                type: "POST",
                url: 'reserv',
                cache: false,
                success: function (html) {
                    jQuery('#cont').html(html);
                }
            });
            return false;
        });
    });
</script>
