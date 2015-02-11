<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script> 
    <?php $this->pageTitle = 'Профиль - '.Yii::app()->name; ?>
</head>


<div class="page-header">
    <h1 style="display: inline;">Профиль</h1>
</div>

<div class="col-lg-6"> 
    <?php $form = $this->beginWidget('CActiveForm'); ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Информация:</h3>
        </div>
        <div class="panel-body">
            <label>Имя: </label>
            <?php echo CHtml::error($model, 'name', array('class' => 'alert alert-danger', 'style' => 'margin-top:10px;')); ?>
            <?php echo CHtml::textField('name', $model['name'], array('class' => 'form-control', 'style' => 'margin-bottom:10px;')); ?> 

            <label>Фамилия: </label>
            <?php echo CHtml::error($model, 'surname', array('class' => 'alert alert-danger', 'style' => 'margin-top:10px;')); ?>
            <?php echo CHtml::textField('surname', $model['surname'], array('class' => 'form-control', 'style' => 'margin-bottom:10px;')); ?>   

            <label>E-mail: </label>
            <?php echo CHtml::error($model, 'mail', array('class' => 'alert alert-danger', 'style' => 'margin-top:10px;')); ?>
            <?php echo CHtml::textField('mail', $model['mail'], array('class' => 'form-control', 'style' => 'margin-bottom:10px;')); ?>  

            <?php echo CHtml::submitButton('Сохранить', array('name' => 'SaveInfo', 'class' => 'btn btn-success', 'style' => 'float:right; margin-top:10px;')); ?>   
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <?php $form = $this->beginWidget('CActiveForm', array('id' => 'password-form',)); ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Пароль:</h3>
        </div>
        <div class="panel-body">
            <div class="form-group" id="password">   
                <?php echo CHtml::button('Изменить пароль', array('onclick' => '$("#password").hide(); $("#new_password").show();', 'class' => 'btn btn-success', 'style' => 'float:right; margin-top:10px;')); ?>   
            </div>
            <div class="form-group" id="new_password" style="display: none;">
                <label>Введите текущий пароль: </label>
                <?php echo Chtml::passwordField('old_password', '', array('class' => 'form-control')); ?>     

                <label>Введите новый пароль: </label>  
                <?php echo CHtml::textField('new_password', '', array('class' => 'form-control')); ?>   

                <label>Повторите ввод: </label>
                <?php echo CHtml::textField('new_password2', '', array('class' => 'form-control')); ?>   

                <?php echo CHtml::button('Изменить пароль', array('onclick' => 'savePass();', 'id' => 'SavePassword', 'class' => 'btn btn-success', 'style' => 'float:right; margin-top:10px;')); ?>   
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>



<div class="col-lg-6"> 
    <?php $form = $this->beginWidget('CActiveForm'); ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Телефон:</h3>
        </div>
        <div class="panel-body">
            <label>Телефон: </label>
            <div class="form-group" id="code">
                <?php echo CHtml::error($model, 'phone', array('class' => 'alert alert-danger', 'style' => 'margin-top:10px;')); ?>
                <?php echo CHtml::textField('phone', $model['phone'], array('class' => 'form-control')); ?>           
            </div>
            <?php echo CHtml::button('Изменить телефон', array('name' => 'ChangePhone', 'id' => 'ChangePhone', 'class' => 'btn btn-success', 'style' => 'float:right; margin-top:10px;')); ?>   
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <?php $form = $this->beginWidget('CActiveForm'); ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Номер карты:</h3>
        </div>
        <div class="panel-body">
            <label>Номер карты: </label>
            <?php
            if (empty($model['card']))
            {
                echo CHtml::error($model, 'card', array('class' => 'alert alert-danger', 'style' => 'margin-top:10px;'));
                echo CHtml::textField('card', $model['card'], array('class' => 'form-control'));
                echo CHtml::submitButton('Привязать карту', array('name' => 'SaveCard', 'class' => 'btn btn-success', 'style' => 'float:right; margin-top:10px;'));
            } else
                echo CHtml::textField('card', $model['card'], array('class' => 'form-control', 'readonly' => 'readonly'));
            ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
</div>


<script type="text/javascript">
    $(function () {
        $("#ChangePhone").click(function () {
            $.ajax({
                type: "POST",
                url: 'SaveProfile',
                cache: false,
                data: jQuery(this).parents("form").serialize(),
                success: function (html) {
                    if (html != '')
                        jQuery("#code").html(html);
                }
            });
            return false;
        });
    });

    function confirmPhone() {
        $.ajax({
            type: "POST",
            url: 'SaveProfile',
            cache: false,
            data: jQuery(this).parents("form").serialize(),
            success: function (html) {

                jQuery("#code").html(html);
            }
        });
    }
    ;

    function savePass() {
        $.ajax({
            type: "POST",
            url: 'SaveProfile',
            cache: false,
            data: $("#password-form").serialize(),
            success: function (html) {
                jQuery("#new_password").html(html);
            }
        });
        return false;
    }
    ;

</script>