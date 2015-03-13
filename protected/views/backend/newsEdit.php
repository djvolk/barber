<head>
    <script type="text/javascript" src="/js/tinymce/tinymce.min.js" ></script> 
    <script type="text/javascript">
                tinymce.init({
                    selector: "textarea",
                    language: 'ru',
                    height: 200,
                    plugins: 'textcolor preview code image link',
                    toolbar: "fontselect fontsizeselect | forecolor preview code",
                });
    </script>
    <?php
    if ($add == true)
        $this->pageTitle = 'Добавить новость';
    if ($edit == true)
        $this->pageTitle = 'Редактировать новость';
    ?>
</head>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'news',
    'enableAjaxValidation' => false,
    'htmlOptions'          => array('enctype' => 'multipart/form-data'),
        ));
?>
<?php //print_r($array); ?>
<div class="page-header">
    <?php echo CHtml::link('<i class="fa fa-long-arrow-left"></i>', array('backend/news'), array('class' => 'navbar-brand', 'style' => 'color:black;')); ?>                   
    <h1 style="display: inline;">
        <?php
        if ($add == true)
            echo 'Добавить новость';
        if ($edit == true)
            echo 'Редактировать новость';
        ?>
    </h1>
    <?php echo CHtml::submitButton('Сохранить', array('name' => 'Save', 'class' => 'btn btn-success', 'style' => 'float:right;')); ?>   
    <?php echo CHtml::submitButton('Отмена', array('name' => 'Cancel', 'class' => 'btn btn-danger', 'style' => 'float:right;  margin-right: 10px;')); ?>   
</div>

<div class="form-group">
    <label>Название новости</label>
    <?php echo CHtml::error($model, 'title', array('class' => 'alert alert-danger')); ?> 
    <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'placeholder' => 'Введите заголовок', 'autofocus' => true,)); ?>  
</div>

<div class="form-group">
    <label>Вставить картинку</label>
    <?php echo CHtml::error($model, 'pic', array('class' => 'alert alert-danger')); ?>
    <?php echo $form->fileField($model, 'pic', array()); ?> 
    <?php
    if (!empty($model->pic))
        echo '<img class="img-thumbnail" src="'.Yii::app()->getBaseUrl().'/images/news/'.$model->pic.'" alt="">';
    ?>

</div>

<div class="form-group">
    <label>Текст новости</label>
    <?php echo CHtml::error($model, 'text', array('class' => 'alert alert-danger')); ?>
    <?php echo $form->textArea($model, 'text'); ?>
</div>

<div class="form-group">
    <label>Публикация:</label>
    <label class="radio-inline">
        <?php
        echo $form->radioButton($model, 'status', array(
            'value'        => "show",
            'uncheckValue' => null,
            'id'           => 'optionsRadiosInline1',
            'checked'      => true,
        ));
        ?>Опубликовать
    </label>
    <label class="radio-inline">
        <?php
        echo $form->radioButton($model, 'status', array(
            'value'        => "hide",
            'uncheckValue' => null,
            'id'           => 'optionsRadiosInline2'
        ));
        ?>Скрыть
    </label>
</div>
<?php $this->endWidget(); ?>