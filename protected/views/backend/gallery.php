<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>	
    <script type="text/javascript" src="/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="/js/plupload.full.min.js"></script>
    <script type="text/javascript" src="/js/jquery.plupload.queue.js"></script>

    <link rel="stylesheet" href="/css/jquery.plupload.queue.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
        $(document).ready(function () {
            $(".img-thumbnail").fancybox({
                'titlePosition': 'outside',
                'overlayColor': '#000',
                'overlayOpacity': 0.9,
            });

            $("#uploader").pluploadQueue({
                runtimes: 'html5',
                url: 'upload.php',
                chunk_size: '1mb',
                unique_names: false,
                filters: {
                    max_file_size: '10mb',
                    mime_types: [
                        {title: "Изображения", extensions: "jpg,gif,png,gif"},
                    ]
                },
                //resize: {width: 320, height: 240, quality: 90}
            });
        });
    </script>   
    <?php $this->pageTitle = 'Настройка галлереи'; ?>   
</head>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'gallery',
    'enableAjaxValidation' => false,
        ));
?>
<div class="page-header">
    <h1 style="display: inline;">Настройка галлерии</h1>
    <?php echo CHtml::button('Загрузить изображения', array('onclick' => '$("#load").toggle();', 'class' => 'btn btn-success', 'style' => 'float:right;')); ?>
    <?php echo CHtml::link('Редактировать заголовок', array('backend/GalleryTitleEdit'), array('class' => 'btn btn-info', 'style' => 'float:right; margin-right:10px;')); ?>
</div>

    <div id="load" style="display:none;">
        <div id="uploader" style="width:100%; margin: auto;"></div>
        <div style="width:98%; margin: auto;">
            <?php echo CHtml::submitButton('Отменить', array('name' => 'Cancel', 'class' => 'btn btn-danger', 'style' => 'width:40%; margin-top: 10px;')); ?>   
            <?php echo CHtml::submitButton('Добавить в галлерею', array('name' => 'Refresh', 'class' => 'btn btn-success', 'style' => 'width:40%; float:right; margin-top: 10px;')); ?>   
        </div>
    </div>
    <br><br>
    <div>
        <?php
        if (isset($images))
            foreach ($images as $image)
            {
                ?>
                <div class="well" style="display: inline-block; 
                                         text-align: justify;
                                         -moz-text-align-last: justify; 
                                         -webkit-text-align-last: justify; 
                                         text-align-last: justify;">
                    <p><a class="img-thumbnail"  href="/images/gallery/photo/<?= $image['image'] ?>" title="<?= $image['title'] ?>"><img src="/images/gallery/photo/<?= $image['image'] ?>" width="150" height="100"/></a></p>  
                    <?php echo CHtml::link('Удалить', array('backend/DeleteGallery', 'id' => $image['id']), array('class' => 'btn btn-danger', 'style' => 'float:center;', 'confirm' => 'Хотите удалить фотографию?')); ?>                          
                </div>
            <?php } ?>
    </div>
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
        <style>
            ul.pagination .first, ul.pagination .last {
                display: none;
            }
        </style>  
    </div>
</div>
<?php $this->endWidget(); ?>