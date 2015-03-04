<?= CHtml::form(); ?> 
<div class="row">
    <?php echo CHtml::error($form, 'phone', array('style' => 'width: 100%; margin-left: 30px;')); ?>
    <label for="User_phone">Телефон</label>
    <?php
    $phone = Yii::app()->request->cookies['phone']->value;
    if (isset($phone))
    {
        if (User::model()->getRole($phone) == 'user' or User::model()->getRole($phone) == 'admin')
            $form->phone = Yii::app()->request->cookies['phone']->value;
    } else
    {
        $form->phone = '+7';
    }
    echo CHtml::activeTextField($form, 'phone', array('id' => 'phoneLogin'));
    ?>              						
</div>
<div class="row">	
    <label for="User_pass">Пароль</label>	
    <?php echo CHtml::activePasswordField($form, 'password', array('style' => 'width: 130px;')); ?>     
    <div id="navigation" style="margin-top: 2px;">
        <ul style="">
            <li style=""><a href="forgotPassword" rel="nofollow"  style="margin-right: 20px; float: right; font-family: Geneva, Arial, Helvetica, sans-serif; color: grey;" data-speed="1000" data-easing="easeOutBack">ЗАБЫЛИ ПАРОЛЬ?</a></li>
        </ul>
    </div>
</div>
<div id="navigation" style="margin-top: 30px;">
    <ul style="display: inline">
        <li style="display: inline"><a href="OpenRegistration" rel="nofollow" class="button" style="margin-left: 10px;" data-speed="1000" data-easing="easeOutBack">Регистрация</a></li>
    </ul>
    <?php
    echo CHtml::button("ВХОД", array('id' => 'butLogin', 'name' => 'butLogin', 'class' => 'button disabled', 'style' => 'float: right; margin-right: 20px; margin-top:-5px;',));
    ?>  
</div>

<?= CHtml::endForm(); ?>

<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="/js/jquery.mask.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var $phone = $('#phoneLogin').val();
        
        if ($phone.length == 12)
            $('#butLogin').removeClass("disabled");
        else
            $('#butLogin').addClass("disabled");
    });

    $('#phoneLogin').mask("+70000000000");
    $('#phoneLogin').bind("change keyup input click", function () {
        if (this.value.length == 12)
            $('#butLogin').removeClass("disabled");
        else
            $('#butLogin').addClass("disabled");
    });

    $("#butLogin").click(function () {
        $.ajax({
            type: "POST",
            url: 'login',
            cache: false,
            data: jQuery(this).parents("form").serialize(),
            success: function (html) {
                jQuery("#login").html(html);
            }
        });
    });
</script>