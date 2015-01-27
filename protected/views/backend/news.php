<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <?php $this->pageTitle = 'Настройка новостей'; ?>
</head>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'news',
    'enableAjaxValidation' => false,
        ));
?>

<div class="page-header">
    <h1 style="display: inline;">Настройка новостей</h1>
    <?php echo CHtml::submitButton('Добавить новость', array('name' => 'AddNews', 'class' => 'btn btn-success', 'style' => 'float:right;')); ?>   
</div>

<?php
if (isset($news))
    foreach ($news as $new)
    {
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php echo $new['title']; ?>
                        <?php echo CHtml::link('Удалить', array('backend/DeleteNews', 'id' => $new['id']), array('class' => 'btn btn-xs btn-danger', 'style' => 'float:right;', 'confirm' => 'Хотите удалить новость?')); ?>   
                        <?php echo CHtml::link('Изменить', array('backend/EditNews', 'id' => $new['id']), array('class' => 'btn btn-xs btn-warning', 'style' => 'float:right; margin-right: 10px;')); ?>   
                        <?php echo '<span style="float:right; margin-right: 20px; font-weight:bold;">'.$new['date'].'</span>'; ?>
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