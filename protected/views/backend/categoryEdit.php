<head>
    <?php
    if ($add == true)
        $this->pageTitle = 'Добавить категорию';
    if ($edit == true)
        $this->pageTitle = 'Редактировать категорию';
    ?>
</head>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'categoryEdit',
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
            echo 'Добавить категорию';
        if ($edit == true)
            echo 'Редактировать категорию';
        ?>
    </h1>
    <?php echo CHtml::submitButton('Сохранить', array('name' => 'Save', 'class' => 'btn btn-success', 'style' => 'float:right;')); ?>   
    <?php echo CHtml::submitButton('Отмена', array('name' => 'Cancel', 'class' => 'btn btn-danger', 'style' => 'float:right;  margin-right: 10px;')); ?>   
</div>

<div class="form-group">
    <label>Название категории</label>
    <?php echo CHtml::error($model, 'name', array('class' => 'alert alert-danger')); ?> 
    <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'placeholder' => 'Введите название', 'autofocus' => true,)); ?>  
</div>

<div class="form-group">
    <label>Вставить картинку</label>
    <?php echo CHtml::error($model, 'image', array('class' => 'alert alert-danger')); ?>
    <?php echo $form->fileField($model, 'image', array()); ?>  
    <?php if (!empty($model->image))  ?>
    <img class="img-thumbnail" src="<?= Yii::app()->getBaseUrl().'/images/shop/category/'.$model->image ?>" alt="">
</div>

<?php $this->endWidget(); ?>