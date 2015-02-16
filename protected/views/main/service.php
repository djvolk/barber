<head>
    <title><?php echo 'Услуги - '.Yii::app()->name; ?></title>
    <meta name="keywords" content="<?php echo 'Услуги - '.Yii::app()->name; ?>"/>
    <meta name="description" content="<?php echo 'Услуги - '.Yii::app()->name; ?>"/>  
    <link rel="stylesheet" type="text/css" href="/css/service.css" />
</head>    

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


    <div class="box text-center">
        <h2 style="font-size: 2.5em;">МОИ УСЛУГИ</h2>
    </div>
    <div class="clear"></div>
    <?= $service->text ?>
    <div class="clear" style="margin-bottom: 80px;"></div>


    <div class="text-center">
        <h2 style="font-size: 2.5em;">ГАЛЛЕРЕЯ МОИХ РАБОТ</h2>
    </div>
    <div class="gl_col_3" style="margin-top: 40px;">
        <?php
        if (isset($images))
            foreach ($images as $image)
            {
                ?>
                <div class="well">
                    <p><a class="zoomer"  href="/images/gallery/photo/<?= $image['image'] ?>" title="<?= $image['title'] ?>"><img src="/images/gallery/photo/<?= $image['image'] ?>" height="100" /></a></p>                    
                </div>
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
        $('.content_inner').jScrollPane();
        setTimeout(function () {
            $('.content_inner').jScrollPane();
        }, 50);

        jQuery('.zoomer').fancybox({
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

        $("#haircut").click(function () {
            $.ajax({
                type: "POST",
                url: 'reserv',
                cache: false,
                data: {'type': $(this).attr('id')},
                success: function (html) {
                    jQuery('#cont').html(html);
                }
            });
            return false;
        });

        $("#color").click(function () {
            $.ajax({
                type: "POST",
                url: 'reserv',
                cache: false,
                data: {'type': $(this).attr('id')},
                success: function (html) {
                    jQuery('#cont').html(html);
                }
            });
            return false;
        });

    });
</script>
