<?php
$this->pageTitle = 'Регистрация - '.Yii::app()->name;
$this->description = 'Регистрация - '.Yii::app()->name;
$this->keywords = 'Регистрация - '.Yii::app()->name;
?>

<div id="register">
<?= CHtml::form(); ?>
    <div class="register">
        <div class="row">
            <label for="User_mail">Email</label>
             <?php echo CHtml::activeTextField($form, 'mail'); ?>
             <?php  echo CHtml::error($form, 'mail'); ?>
        </div>
        <div class="row" style="margin-top: 20px;">	
            <label for="User_pass">Пароль</label>	
             <?php echo CHtml::activePasswordField($form, 'password'); ?> 
             <?php  echo CHtml::error($form, 'password'); ?>
        </div>
        <div class="row" style="margin-top: 20px;">	
            <label for="User_name">Имя</label>	
            <?php echo CHtml::activeTextField($form, 'name'); ?>
            <?php  echo CHtml::error($form, 'name'); ?>
        </div>
        <div class="row">	
            <label for="User_surname">Фамилия</label>	
            <?php echo CHtml::activeTextField($form, 'surname'); ?>
            <?php  echo CHtml::error($form, 'surname'); ?>
        </div>
        <div class="row" style="margin-top: 20px;">	
            <label for="User_phone">Телефон</label>	
            <?php echo CHtml::activeTextField($form, 'phone'); ?>
            <?php echo CHtml::error($form, 'phone', array()); ?>
            <br><span style="margin-left: 108px;">будет отправлено sms с кодом подтверждения</span>           
        </div>
        <div class="row">	
            <label for="User_card">Номер карты</label>	
            <?php echo CHtml::activeTextField($form, 'card'); ?>
            <?php echo CHtml::error($form, 'card', array('style' => 'width: 180px;')); ?>               
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