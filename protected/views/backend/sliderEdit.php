<head>
    <?php
    if ($add == true)
        $this->pageTitle = 'Добавить фотографию';
    if ($edit == true)
        $this->pageTitle = 'Редактировать фотографию';
    ?>
</head>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'sliderEdit',
    'enableAjaxValidation' => false,
    'htmlOptions'          => array('enctype' => 'multipart/form-data'),
        ));
?>
<?php //print_r($array); ?>
<div class="page-header">
    <?php echo CHtml::link('<i class="fa fa-long-arrow-left"></i>', array('backend/slider'), array('class' => 'navbar-brand', 'style'=>'color:black;')); ?>
    <h1 style="display: inline;">
        <?php
        if ($add == true)
            echo 'Добавить фотографию';
        if ($edit == true)
            echo 'Редактировать фотографию';
        ?>
    </h1>
    <?php echo CHtml::submitButton('Сохранить', array('name' => 'Save', 'class' => 'btn btn-success', 'style' => 'float:right;')); ?>   
    <?php echo CHtml::submitButton('Отмена', array('name' => 'Cancel', 'class' => 'btn btn-danger', 'style' => 'float:right;  margin-right: 10px;')); ?>   
</div>

<div class="form-group">
    <label>Название фотографии:</label>
    <?php echo CHtml::error($model, 'comment', array('class' => 'alert alert-danger')); ?> 
    <?php echo $form->textField($model, 'comment', array('class' => 'form-control', 'placeholder' => 'Введите название', 'autofocus' => true,)); ?>  
</div>

<div class="form-group">
    <label>фотография:</label>
    <?php echo CHtml::error($model, 'image', array('class' => 'alert alert-danger')); ?>
    <?php echo $form->fileField($model, 'image', array()); ?>  
    <?php if (!empty($model->image))  ?>
    <img class="img-thumbnail" src="<?= Yii::app()->getBaseUrl().'/images/slider/'.$model->image ?>" alt="">
</div>

<?php $this->endWidget(); ?>