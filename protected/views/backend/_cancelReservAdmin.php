<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'cancel',
    'enableAjaxValidation' => false,
        ));
?>
<div class="checkbox">
    <label>
        <input name="sms_checkbox" id="sms_checkbox" type="checkbox" value="sms">Отправить SMS с причной отказа
    </label>
</div>
<input type="hidden" value="<?=$id?>" name="id">
<?php echo CHtml::textArea('sms', '', array('class' => 'form-control', 'style' => 'resize:none;', 'rows' => 3, 'id' => 'sms', 'placeholder' => 'Введите текст SMS', 'disabled' => 'disabled')); ?>  
<?php echo CHtml::submitButton('Отменить запись', array('name' => 'Cancel', 'class' => 'btn btn-danger', 'style' => 'float:right; margin-top:10px;')); ?>   
<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(function () {
        $("#sms_checkbox").change(function () {
            if ($("#sms_checkbox").prop("checked"))
                $('#sms').removeAttr("disabled");
            else
                $('#sms').attr('disabled', 'disabled');
        });
    });
</script>