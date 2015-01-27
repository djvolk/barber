<?= CHtml::form(); ?> 
<div class="row">
    <?php echo CHtml::error($form, 'mail'); ?>
    <label for="User_mail">Email</label>
    <?php echo CHtml::activeTextField($form, 'mail'); ?>              						
</div>
<div class="row">	
    <label for="User_pass">Пароль</label>	
    <?php echo CHtml::activePasswordField($form, 'password', array('style' => 'width: 130px;')); ?>     
    <div id="navigation" style="margin-top: 2px;">
        <ul style="">
            <li style=""><a href="index.php?r=main/forgotPassword"  style="margin-right: 20px; float: right; font-family: Geneva, Arial, Helvetica, sans-serif; color: grey;" data-speed="1000" data-easing="easeOutBack">ЗАБЫЛИ ПАРОЛЬ?</a></li>
        </ul>
    </div>
</div>
<div id="navigation" style="margin-top: 30px;">
    <ul style="display: inline">
        <li style="display: inline"><a href="index.php?r=main/registration" class="button" style="margin-left: 10px;" data-speed="1000" data-easing="easeOutBack">Регистрация</a></li>
    </ul>
    <?php
    echo CHtml::button("ВХОД", array('id' => 'butLogin', 'name' => 'butLogin', 'class' => 'button', 'style' => 'float: right; margin-right: 20px; margin-top:-5px;',));
    ?>  
</div>

<?= CHtml::endForm(); ?>

<script type="text/javascript" src="js/menu.js"></script>

<script type="text/javascript">
    $("#butLogin").click(function () {
        $.ajax({
            type: "POST",
            url: '/index.php?r=main/login',
            cache: false,
            data: jQuery(this).parents("form").serialize(),
            success: function (html) {
                jQuery("#login").html(html);
            }
        });
    });
</script>