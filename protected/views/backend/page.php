<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script>
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
    if ($page->page == 'service')
        $this->pageTitle = 'Услуги';
    if ($page->page == 'shop')
        $this->pageTitle = 'Магазин';
    if ($page->page == 'gallery')
        $this->pageTitle = 'Галлерея';
    ?> 
</head>


<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'page',
    'enableAjaxValidation' => false,
        ));
?>

<div class="page-header">
    <?php
    if ($page->page == 'shop')
        echo CHtml::link('<i class="fa fa-long-arrow-left"></i>', array('backend/shop'), array('class' => 'navbar-brand', 'style'=>'color:black;'));
    if ($page->page == 'gallery')
        echo CHtml::link('<i class="fa fa-long-arrow-left"></i>', array('backend/gallery'), array('class' => 'navbar-brand', 'style'=>'color:black;'));
    ?>       
    <h1 style="display: inline;">
        <?php
        if ($page->page == 'service')
            echo 'Настройка страницы "Услуги"';
        if ($page->page == 'shop')
            echo 'Настройка заголовка магазина';
        if ($page->page == 'gallery')
            echo 'Настройка заголовка галлерии';
        ?>    
    </h1> 
    <?php echo CHtml::submitButton('Сохранить', array('name' => 'Save', 'class' => 'btn btn-success', 'style' => 'float:right;')); ?>   
</div>

<div class="form-group">
    <label>Текст:</label>
    <?php echo $form->textArea($page, 'text'); ?>
</div>

<?php $this->endWidget(); ?>
