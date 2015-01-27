<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <?php $this->pageTitle = 'Настройка слайдера'; ?>
</head>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'slider',
    'enableAjaxValidation' => false,
        ));
?>

<div class="page-header">
    <h1 style="display: inline;">Настройка слайдера</h1>
    <?php echo CHtml::submitButton('Добавить фотографию', array('name' => 'AddSlider', 'class' => 'btn btn-success', 'style' => 'float:right;')); ?>   
</div>

<?php
if (isset($images))
    foreach ($images as $image)
    {
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <img class="img-thumbnail" src="<?= Yii::app()->getBaseUrl().'/images/slider/'.$image->image ?>" alt="" width="200" height="200" style="margin-right: 10px;">
                        <?php echo mb_strimwidth($image['comment'], 0, 30, "...");?>
                        <div class="pull-right" style="padding-top: 50px;">
                        <?php echo CHtml::link('Изменить', array('backend/EditSlider', 'id' => $image['id']), array('class' => 'btn btn-warning', 'style' => 'margin-right: 10px;')); ?>   
                        <?php echo CHtml::link('Удалить', array('backend/DeleteSlider', 'id' => $image['id']), array('class' => 'btn btn-danger', 'style' => '', 'confirm' => 'Хотите удалить фото?')); ?>   
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

<div class="text-center">
    <?php
    $this->widget('CLinkPager', array(
        'pages'                => $pages,
        'header'               => '',
        'nextPageLabel'        => '>>',
        'prevPageLabel'        => '<<',
        'firstPageLabel'       => 'Первая',
        'lastPageLabel'        => 'Последняя',
        'selectedPageCssClass' => 'active',
        'hiddenPageCssClass'   => 'disabled',
        'htmlOptions'          => array(
            'class' => 'pagination',
            'style' => 'margin-bottom: 0px;',
        )
    ))
    ?>
</div>
<style>
    ul.pagination .first, ul.pagination .last {
        display: none;
    }
</style>  
<?php $this->endWidget(); ?>