<head>
    <link rel="stylesheet" type="text/css" href="css/YiiBootstrap.css" /> 
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <?php $this->pageTitle = 'Настройки графика и услуг'; ?>
</head>


<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'reservSetting',
    'enableAjaxValidation' => false,
        ));
?>

<div class="page-header">
    <h1 style="display: inline;">Настройки графика и услуг</h1> 
</div>

<div class="col-lg-12">
    <div class="panel panel-default" style="padding-right: 0px;">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Уведомления 
            </h3>
        </div> 

        <div class="panel-body">
            <div class="col-lg-4">
                <label>Номер телефона:</label>
                <?php echo CHtml::textField('sms_phone', $settings['sms_phone'], array('class' => 'form-control', 'style' => 'width:80%;')); ?>
                <label>
                    <?php echo CHtml::CheckBox('sms', $settings['checkbox-sms'], array('value' => 'true')); ?>
                    Отправлять SMS уведомления
                </label>
            </div>
            <div class="col-lg-4">
                <label>E-mail уведомлений:</label>
                <?php echo CHtml::textField('mail', $settings['mail'], array('class' => 'form-control', 'style' => 'width:80%;')); ?>
            </div>            
            <div class="clearfix"></div>
            <?php echo CHtml::submitButton('Сохранить', array('name' => 'saveReport', 'class' => 'btn btn-success', 'style' => 'float:right; margin-top:10px;')); ?>   
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="panel panel-yellow" style="padding-right: 0px;">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Время 
            </h3>
        </div> 

        <div class="panel-body">
            <div class="col-lg-4">
                <label>Период рабочего дня:</label>
                <?php echo CHtml::dropDownList('period_day', $settings['period_day'], CHtml::listData(Settings::model()->getPeriodSetting(), 'value', 'text'), array('class' => 'form-control', 'style' => 'width:80%;')); ?>
            </div>
            <div class="col-lg-4">
                <label>Начало рабочего дня:</label>
                <?php echo CHtml::dropDownList('start_day', $settings['start_day'], CHtml::listData(Settings::model()->getTimeSetting(), 'value', 'text'), array('class' => 'form-control', 'style' => 'width:80%;')); ?>
            </div>
            <div class="col-lg-4">
                <label>Конец рабочего дня:</label>
                <?php echo CHtml::dropDownList('end_day', $settings['end_day'], CHtml::listData(Settings::model()->getTimeSetting(), 'value', 'text'), array('class' => 'form-control', 'style' => 'width:80%;')); ?>
            </div>
            <?php echo CHtml::submitButton('Сохранить', array('name' => 'saveTime', 'class' => 'btn btn-warning', 'style' => 'float:right; margin-top:10px;')); ?>   
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="panel panel-primary" style="padding-right: 0px;">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Услуги 
            </h3>
        </div> 

        <div class="panel-body">
            <ul class="list-group">     
                <?php
                if (isset($operations))
                    foreach ($operations as $operation)
                    {
                        echo '<li class="list-group-item">'.$operation->name.
                        CHtml::link('Удалить', array('backend/DeleteOperation', 'id' => $operation->id), array('class' => 'btn btn-xs btn-danger', 'style' => 'float:right;', 'confirm' => 'Хотите удалить '.$operation->name.'?')).
                        '<span class="badge" style="margin-right: 50px;">'.$operation->discount_price.' рублей (по карте)</span>'.
                        '<span class="badge" style="margin-right: 50px;">'.$operation->price.' рублей</span>'.
                        '<span class="badge" style="margin-right: 50px; background-color:#d9534f;">'.$operation->time.' минут</span>'.'</li>';
                    }
                echo '<br>';
                echo CHtml::link('Добавить услугу', array(), array('class' => 'btn btn-default btn-primary', 'style' => 'float:right;', 'onclick' => '$("#new_operation").dialog("open"); return false;'));
                ?>
            </ul>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'      => 'new_operation',
    'options' => array(
        'title'     => 'Добавить услугу',
        'autoOpen'  => false,
        'modal'     => true,
        'resizable' => false,
        'draggable' => false,
        'width'     => 500,
    )
));
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'new_operation_form',
    'enableAjaxValidation' => true,
        ));
?>
<div id="operation_form">
    <div class="form-group">
        <label>Название:</label>
        <?php echo CHtml::error($model, 'name', array('class' => 'alert alert-danger')); ?> 
        <?php echo CHtml::textField('name', $model['name'], array('class' => 'form-control', 'autofocus' => true,)); ?>  
    </div>
    <div class="col-lg-4" style="padding-left: 0;">
        <div class="form-group">
            <label>Время:</label>
            <?php echo CHtml::error($model, 'time', array('class' => 'alert alert-danger')); ?> 
            <?php echo CHtml::textField('time', $model['time'], array('class' => 'form-control', 'placeholder' => 'минуты')); ?>  
        </div>
    </div>
    <div class="col-lg-4" style="padding-right: 0;">    
        <div class="form-group">
            <label>Цена:</label>
            <?php echo CHtml::error($model, 'price', array('class' => 'alert alert-danger')); ?> 
            <?php echo CHtml::textField('price', $model['price'], array('class' => 'form-control', 'placeholder' => 'рубли')); ?>  
        </div>
    </div>
    <div class="col-lg-4" style="padding-right: 0;">    
        <div class="form-group">
            <label>Цена по карте:</label>
            <?php echo CHtml::error($model, 'discount_price', array('class' => 'alert alert-danger')); ?> 
            <?php echo CHtml::textField('discount_price', $model['discount_price'], array('class' => 'form-control', 'placeholder' => 'рубли')); ?>  
        </div>
    </div>       
    <div class="form-group">
        <label>Комментарий (необязательно):</label> 
        <?php echo CHtml::textArea('comment', $model['comment'], array('class' => 'form-control', 'style' => 'resize: none;')); ?>  
    </div>
</div>
<?php
echo CHtml::ajaxSubmitButton(
        'Сохранить', array('backend/ReservSetting'), array(
    'type'     => 'post',
    'dataType' => 'json',
    'update'   => '#operation_form',
    'success'  => "function(data)
            {
                if (data.status == 'success')
                {
                    window.location.reload(true);
                } 
                else
                {
                    $('#operation_form').html(data.div);
                }
            } ",
        ), array('class' => 'btn btn-default btn-success', 'style' => 'float:right;',)
);
?>
<?php $this->endWidget(); ?>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
