<head>
    <script type="text/javascript" src="/js/tinymce/tinymce.min.js" >"></script> 
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
        $this->pageTitle = 'Добавить товар';
    if ($edit == true)
        $this->pageTitle = 'Редактировать товар';
    ?>
</head>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'addProduct',
    'enableAjaxValidation' => false,
    'htmlOptions'          => array('enctype' => 'multipart/form-data'),
        ));
?>
<?php //print_r($array); ?>
<div class="page-header">
    <?php echo CHtml::link('<i class="fa fa-long-arrow-left"></i>', array('backend/shop'), array('class' => 'navbar-brand', 'style'=>'color:black;')); ?>                   
    <h1 style="display: inline;">
        <?php
        if ($add == true)
            echo 'Добавить товар';
        if ($edit == true)
            echo 'Редактировать товар';
        ?>
    </h1>
    <?php if ($edit == true) echo CHtml::link('Удалить товар', array('backend/DeleteProduct', 'id' => $model->id), array( 'class' => 'btn btn-danger', 'style' => 'float:right; margin-right: 10px;', 'confirm' => 'Хотите удалить товар?')); ?>                   
</div>

<div class="form-group">
    <label>Название товара</label>
    <?php echo CHtml::error($model, 'title', array('class' => 'alert alert-danger')); ?> 
    <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'placeholder' => 'Введите заголовок', 'autofocus' => true,)); ?>  
</div>

<div class="form-group">
    <label>Категория товара:</label>
    <?php
    echo $form->dropDownList($model, 'category_id', CHtml::listData(Category::model()->findAll(), 'id', 'name'), array('class' => 'form-control', 'style' => 'width: 30%;'));
    ?>
</div>
<div class="form-group">
    <label>В наличии</label>
    <?php echo CHtml::error($model, 'in_stock', array('class' => 'alert alert-danger')); ?> 
    <?php echo $form->textField($model, 'in_stock', array('class' => 'form-control', 'maxlength' => 3, 'style' => 'width: 50px;')); ?>  
</div>

<div class="form-group">
    <label>Кратное описание</label>
    <?php echo CHtml::error($model, 'brief_description', array('class' => 'alert alert-danger')); ?>
    <?php echo $form->textArea($model, 'brief_description'); ?>
</div>

<div class="form-group">
    <label>Полное описание описание</label>
    <?php echo CHtml::error($model, 'description', array('class' => 'alert alert-danger')); ?>
    <?php echo $form->textArea($model, 'description'); ?>
</div>

<div class="form-group">
    <label>Вставить картинку</label>
    <?php echo CHtml::error($model, 'image', array('class' => 'alert alert-danger')); ?>
    <?php echo $form->fileField($model, 'image', array()); ?> 
    <?php
    if (!empty($model->image))
        echo '<img class="img-thumbnail" src="'.Yii::app()->getBaseUrl().'/images/shop/products/'.$model->image.'" alt="">';
    ?>
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
<?php echo CHtml::submitButton('Сохранить', array('name' => 'Save', 'class' => 'btn btn-success', 'style' => 'float:right;')); ?>   
<?php echo CHtml::submitButton('Отмена', array('name' => 'Cancel', 'class' => 'btn btn-default', 'style' => 'float:right;  margin-right: 10px;')); ?>   

<?php $this->endWidget(); ?>