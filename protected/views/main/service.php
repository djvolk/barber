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

    <div class="one_third" style="width:370px; font-family:'Pompadur'; color: #fff;">
        <div class="text-center">
            <h2 style="font-size: 2.5em;">ОБО МНЕ</h2>
        </div>
        <span style="margin-left: 10px; font-size: 16px;">
            Я парикмахер универсал с более чем 15-ти летним стажем работы в парикмахерском бизнесе,
            у меня есть свой неповторимый и узнаваемый стиль, мастерство отточенное годами практики. 
        </span><br><br>
            <span style="margin-left: 10px; font-size: 16px;">
            Я принимал участие в российских и международных конкурсах. Регулярные 
            мастерклассы и семинары помогают мне всегда оставаться на вершине мастерства и 
            быть в курсе последних тенденций мира красоты.</span>
    </div>

    <div class="clear" style="margin-bottom: 20px;"></div>
    <div class="box text-center">
        <h2 style="font-size: 2.5em;">МОИ УСЛУГИ</h2>
    </div>
    <div class="clear"></div>
    <?= $service->text ?>
    <div class="clear" style="margin-bottom: 80px;"></div>

    <div class="text-center">
        <h2 style="font-size: 2.5em;">ЧТО Я ИСПОЛЬЗУЮ</h2>
    </div>
    <div style="margin-bottom: 10px;">
        <a class="fancybox" rel="gallery2" href="/images/cosmetic/crew2.png" title="">
            <img src="/images/cosmetic/crew2.png" alt=""  height="175" />
        </a>
        <a class="fancybox" style="float:right;" rel="gallery2" href="/images/cosmetic/rewlon1.jpg" title="">
            <img src="/images/cosmetic/rewlon1.jpg" alt=""  height="175" />
        </a>      
    </div>
    <div style="margin-bottom: 10px;">
        <a class="fancybox" rel="gallery2" href="/images/cosmetic/greymy1.jpg" title="">
            <img src="/images/cosmetic/greymy1.jpg" alt=""  height="170" />
        </a>       
        <a class="fancybox" style="float:right;" rel="gallery2" href="/images/cosmetic/oro3.jpg" title="">
            <img src="/images/cosmetic/oro3.jpg" alt=""  height="170" />
        </a>
    </div>
    <div  style="">
        <a class="fancybox" rel="gallery2" href="/images/cosmetic/sw.jpg" title="">
            <img src="/images/cosmetic/sw.jpg" alt=""  height="70" />
        </a>
        <a class="fancybox" style="float:right;" rel="gallery2" href="/images/cosmetic/af.jpg" title="">
            <img src="/images/cosmetic/af.jpg" alt=""  height="70" />
        </a>       
    </div>

    <div class="clear" style="margin-bottom: 40px;">&nbsp;</div>

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
        $('.content_wrapper').height(2200);
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
