<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="/js/tinymce/tinymce.min.js" ></script> 
    <script type="text/javascript">
                tinymce.init({
                    selector: "textarea",
                    language: 'ru',
                    height: 200,
                    plugins: 'textcolor preview code image link',
                    toolbar: "fontselect fontsizeselect | forecolor preview code",
                    content_css : ["/css/style.css", "/css/service.css"],
                    theme_advanced_fonts :"Pompadur",
                });
    </script>
    <?php $this->pageTitle = 'Услуги'; ?> 
</head>


<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'page',
    'enableAjaxValidation' => false,
        ));
?>

<div class="page-header">    
    <h1 style="display: inline;">Настройка страницы "Услуги"</h1> 
    <?php echo CHtml::submitButton('Сохранить', array('name' => 'Save', 'class' => 'btn btn-success', 'style' => 'float:right;')); ?>   
</div>

    <div class="form-group">
        <label>Мои услуги:</label>
    <?php echo $form->textArea($service, 'text', array('name' => 'service')); ?>
    </div>
    <div class="form-group">
        <label>Отзывы:</label>
    <?php echo $form->textArea($reviews, 'text', array('name' => 'reviews')); ?>
    </div>


<?php $this->endWidget(); ?>

<style>
    .quote-text {
        font-size: 16px;
    }
    .quote-author {
        font-size: 14px;
    }

    .well {
        display: inline-block; 
        text-align: justify;
        -moz-text-align-last: justify; 
        -webkit-text-align-last: justify; 
        text-align-last: justify; 
    }

    .well p {
        margin-right: 10px;
    }

    .option {
        font-size: 18px;
        line-height: 1;
        margin-bottom: .5em;
        font-family: 'Pompadur';
        font-weight: normal;
        color: #fff;
    }

    .option li{
        margin-bottom:10px;
    }

    .lastli {
        font-family: 'Pompadur';
        font-size: 24px; 
        color: #e9403b; 
        font-weight: bold;
    }

    .big {
        font-family: 'Pompadur';
        font-size: 32px; 
        color: #e9403b; 
        font-weight: bold;
    }

    .box {
        background: #2c2c2c;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
        position: relative;
        padding: 20px 10px 5px 10px;
        margin-bottom: 25px;
    }

    .want {   
        display:inline;
        width: 100%;
        margin-top:5px;
        background:#009F52;
        color:#ffffff;
        font-family:'Pompadur';
        font-size:22px;
        padding:.4em .8em;
        border:none;
        cursor:pointer;
        -moz-transition:all 200ms linear 0s;
        -webkit-transition:all 200ms linear 0s;
        -o-transition:all 200ms linear 0s;
        transition:all 200ms linear 0s;
    }

    .want:hover {  
        background: #00D66F;		
        color: #fff;
    }

</style>