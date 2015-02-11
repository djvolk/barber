<head>
    <title><?php echo 'Регистрация - '.Yii::app()->name; ?></title>
    <meta name="keywords" content="<?php echo 'Регистрация - '.Yii::app()->name; ?>"/>
    <meta name="description" content="<?php echo 'Регистрация - '.Yii::app()->name; ?>"/>   
</head>

<div class="home_container">
    <h2>Регистрация</h2>	
</div><!--/ home_container-->
<div class="content_inner" id="register">
<?= CHtml::form(); ?>
    <div class="register">
        <div class="row">
            <label for="User_mail">Email</label>
             <?php echo CHtml::activeTextField($form, 'mail'); ?>
        </div>
        <div class="row" style="margin-top: 20px;">	
            <label for="User_password">Пароль</label>	
             <?php echo CHtml::activePasswordField($form, 'password'); ?>                 						
        </div>
        <div class="row" style="margin-top: 20px;">	
            <label for="User_name">Имя</label>	
            <?php echo CHtml::activeTextField($form, 'name'); ?>                  						
        </div>
        <div class="row">	
            <label for="User_surname">Фамилия</label>	
            <?php echo CHtml::activeTextField($form, 'surname'); ?>                  						
        </div>
        <div class="row" style="margin-top: 20px;">	
            <label for="User_phone">Телефон</label>	
            <?php echo CHtml::activeTextField($form, 'phone'); ?>
            <br><span style="margin-left: 108px;">будет отправлено sms с кодом подтверждения</span>
        </div>
        <div class="row">	
            <label for="User_card">Номер карты</label>	
            <?php echo CHtml::activeTextField($form, 'card'); ?>                  						
        </div>
        <?php
        echo CHtml::button("РЕГИСТРАЦИЯ", array('id' => 'butReg', 'name' => 'butReg', 'class' => 'button', 'style' => 'margin-left: 54%;',));
        ?>     
    </div>
<?= CHtml::endForm(); ?>
</div><!--/ content_inner-->

<script type="text/javascript">
        $("#butReg").click(function () {
            $.ajax( {
                type: "POST",
                url: 'registration',
                cache: false,
                data: jQuery(this).parents("form").serialize(),
                success: function (html) {
                    jQuery("#register").html(html);
                }
        });
    });
</script>