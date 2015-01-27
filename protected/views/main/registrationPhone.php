<?php
/* @var $this MainController */
/* @var $dataProvider CActiveDataProvider */
?>
<?php $this->pageTitle = 'Регистрация - '.Yii::app()->name; ?>

<div id="register">
    <?= CHtml::form(); ?>
    <div class="register">
        <div class="row">
            <label for="User_mail">Email</label>
            <?php echo CHtml::activeTextField($form, 'mail', array('readonly' => 'readonly')); ?>
            <?php echo CHtml::error($form, 'mail'); ?>
        </div>
        <div class="row" style="margin-top: 20px;">	
            <label for="User_pass">Пароль</label>	
            <?php echo CHtml::activePasswordField($form, 'password', array('readonly' => 'readonly')); ?> 
            <?php echo CHtml::error($form, 'password'); ?>
        </div>
        <div class="row" style="margin-top: 20px;">	
            <label for="User_name">Имя</label>	
            <?php echo CHtml::activeTextField($form, 'name', array('readonly' => 'readonly')); ?>
            <?php echo CHtml::error($form, 'name'); ?>
        </div>
        <div class="row">	
            <label for="User_surname">Фамилия</label>	
            <?php echo CHtml::activeTextField($form, 'surname', array('readonly' => 'readonly')); ?>
            <?php echo CHtml::error($form, 'surname'); ?>
        </div>
        <div class="row" style="margin-top: 20px;">	
            <label for="User_phone">Телефон</label>	
            <?php echo CHtml::activeTextField($form, 'phone', array('readonly' => 'readonly')); ?>
            <?php echo CHtml::error($form, 'phone', array()); ?>
            <br><span style="margin-left: 138px; font-size: 12pt; color:#5cb85c;">отправлено sms с кодом</span>           
        </div>
        <div class="row">	
            <label for="User_code" style="color:#5cb85c;">Введите код</label>	
            <?php echo CHtml::TextField('code', '', array('class' => 'code')); ?>                  						
        </div>
        <div class="row">	
            <label for="User_card">Номер карты</label>	
            <?php echo CHtml::activeTextField($form, 'card', array('readonly' => 'readonly')); ?>                  						
        </div>
        <?php
        echo CHtml::button("ПОДТВЕРДИТЬ", array('id' => 'butReg', 'name' => 'butReg', 'class' => 'button', 'style' => 'margin-left: 54%; border-color: #5cb85c;',));
        ?>     
    </div>
    <?= CHtml::endForm(); ?>
</div><!--/ content_inner-->

<script type="text/javascript">
    $("#butReg").click(function () {
        $.ajax({
            type: "POST",
            url: '/index.php?r=main/registration',
            cache: false,
            data: jQuery(this).parents("form").serialize(),
            success: function (html) {
                jQuery("#register").html(html);
            }
        });
    });
</script>