<head>
    <title><?php echo 'Регистрация - '.Yii::app()->name; ?></title>
    <meta name="keywords" content="<?php echo 'Регистрация - '.Yii::app()->name; ?>"/>
    <meta name="description" content="<?php echo 'Регистрация - '.Yii::app()->name; ?>"/>   
</head>

<div class="home_container">
    <h2>Регистрация <?= Yii::app()->session['code2'] ?></h2>	
</div><!--/ home_container-->
<div class="content_inner" id="register">
    <?= CHtml::form(); ?>
    <div class="register">
        <?php
        if (!isset($form->phone))
        {
            $phone = Yii::app()->request->cookies['phone']->value;
            if (isset($phone))
            {
                if (User::model()->getRole($phone) == 'guest')
                    $form->phone = Yii::app()->request->cookies['phone']->value;
            } else
            {
                $form->phone = '+7';
            }
        }
        ?>


        <div class="one_third" style="margin-top: 10px;">
            <label>Телефон</label>
        </div>
        <div class="one_third" >
            <?php echo CHtml::activeTextField($form, 'phone', array('id' => 'phoneReg')); ?>              
            <div class="clear"></div>
            <span id="sms" style="">будет отправлено sms с кодом подтверждения</span>
            <span id="sms_send" style="font-size: 12pt; color:#5cb85c;  display: none;">отправлено sms с кодом</span> 
        </div>
        <div class="one_third_last" style="margin-top: 10px;">
            <?php echo CHtml::error($form, 'phone', array()); ?>
        </div>


        <div class="one_third code" style="margin-top: 30px; display: none;">
            <label style="color:#5cb85c;">Введите код</label>
        </div>
        <div class="one_third code" style="margin-top: 20px;  display: none;">
            <?php echo CHtml::TextField('code', '', array('class' => 'code')); ?> 
        </div>
        <div class="one_third_last code" style="margin-top: 30px;  display: none;">
            <?php echo CHtml::error($form, 'code', array()); ?>
        </div>


        <div class="one_third" style="margin-top: 30px;">
            <label>Пароль</label>
        </div>
        <div class="one_third" style="margin-top: 20px;">
            <?php echo CHtml::activePasswordField($form, 'password', array('id' => 'passwordReg')); ?> 
        </div>
        <div class="one_third_last" style="margin-top: 25px;">
            <?php echo CHtml::error($form, 'password', array()); ?>
        </div>

        <div class="one_third" style="margin-top: 30px;">
            <label>Карта клиента </label>
        </div>
        <div class="one_third" style="margin-top: 20px;">
            <?php echo CHtml::activeTextField($form, 'card'); ?> 
        </div>
        <div class="one_third_last" style="margin-top: 10px;">
            <?php echo CHtml::error($form, 'card', array()); ?>
        </div>

        <div class="one_third" style="margin-top: 30px; margin-left: 223px;">
            <?php echo CHtml::button("РЕГИСТРАЦИЯ", array('id' => 'butRegistration', 'name' => 'butReg', 'class' => 'button', 'style' => '',)); ?>  
            <?php echo CHtml::button("РЕГИСТРАЦИЯ", array('id' => 'butConfirm', 'name' => 'butReg', 'class' => 'button', 'style' => 'display:none;',)); ?>
        </div>

        <!--        <div class="row">
                    <label for="User_mail">Email</label>
        <?php echo CHtml::activeTextField($form, 'mail'); ?>
        <?php echo CHtml::error($form, 'mail'); ?>
                </div>
                <div class="row" style="margin-top: 20px;">	
                    <label for="User_name">Имя</label>	
        <?php echo CHtml::activeTextField($form, 'name'); ?>
        <?php echo CHtml::error($form, 'name'); ?>
                </div>
                <div class="row">	
                    <label for="User_surname">Фамилия</label>	
        <?php echo CHtml::activeTextField($form, 'surname'); ?> 
        <?php echo CHtml::error($form, 'surname'); ?>
                </div>-->   
    </div>
    <?= CHtml::endForm(); ?>
</div><!--/ content_inner-->

<script type="text/javascript" src="/js/jquery.mask.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        var $phone = $('#phoneReg').val();

        if ($phone.length == 12)
            $('#butRegistration').removeClass("disabled");
        else
            $('#butRegistration').addClass("disabled");
    });

    $('#phoneReg').mask("+70000000000");
    $('#phoneReg').bind("change keyup input click", function () {
        if (this.value.length == 12)
            $('#butRegistration').removeClass("disabled");
        else
            $('#butRegistration').addClass("disabled");
    });


    $("#butRegistration").click(function () {
        $.ajax({
            type: "POST",
            url: 'registration',
            cache: false,
            data: jQuery(this).parents("form").serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.status == 'code')
                {
                    jQuery("#cont").html(data.html);
                    $('#phoneReg').attr('readonly', 'readonly');
                    $('#passwordReg').attr('readonly', 'readonly');
                    $("#sms").hide();
                    $("#sms_send").show();
                    $(".code").show();
                    $("#butRegistration").hide();
                    $("#butConfirm").show();
                }
                else
                {
                    jQuery("#cont").html(data.html);
                }
            }
        });
    });

    $("#butConfirm").click(function () {
        $.ajax({
            type: "POST",
            url: 'EndRegistration',
            cache: false,
            data: jQuery(this).parents("form").serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.status == 'code')
                {
                    jQuery("#cont").html(data.html);
                    $('#phoneReg').attr('readonly', 'readonly');
                    $('#passwordReg').attr('readonly', 'readonly');
                    $("#sms").hide();
                    $("#sms_send").show();
                    $(".code").show();
                    $("#butRegistration").hide();
                    $("#butConfirm").show();
                }
                else
                {
                    jQuery("#cont").html(data.html);
                }
            }
        });
    });

</script>