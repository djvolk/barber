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
                url: '/upload.php',
                chunk_size: '1mb',
                unique_names: false,
                filters: {
                    max_file_size: '10mb',
                    mime_types: [
                        {title: "Изображения", extensions: "jpg,gif,png,gif"},
                    ]
                },
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
<!-- ЛОГИРОВАНИЕ <pre id="log" style="height: 300px; overflow: auto"></pre>-->
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
                <p><a class="img-thumbnail"  href="/images/gallery/photo/<?= $image['image'] ?>" title="<?= $image['title'] ?>"><img src="/images/gallery/photo/<?= $image['image'] ?>" height="100" /></a></p>  
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

<!-- СКРИПТ ЗАГРУЗКИ С ЛОГИРОВАНИЕМ
    <script type="text/javascript">
        $(document).ready(function () {
            $("#uploader").pluploadQueue({
                runtimes: 'html5',
                url: '/upload.php',
                chunk_size: '1mb',
                unique_names: false,
                filters: {
                    max_file_size: '10mb',
                    mime_types: [
                        {title: "Изображения", extensions: "jpg,gif,png,gif"},
                    ]
                },
                views: {
                    list: true,
                    thumbs: true, // Show thumbs
                    active: 'thumbs'
                },
                
                            // PreInit events, bound before any internal events
                preinit : {
                    Init: function(up, info) {
                        log('[Init]', 'Info:', info, 'Features:', up.features);
                    },

                    UploadFile: function(up, file) {
                        log('[UploadFile]', file);

                        // You can override settings before the file is uploaded
                        // up.setOption('url', 'upload.php?id=' + file.id);
                        // up.setOption('multipart_params', {param1 : 'value1', param2 : 'value2'});
                    }
                },

                // Post init events, bound after the internal events
                init : {
                    PostInit: function() {
                        // Called after initialization is finished and internal event handlers bound
                        log('[PostInit]');

                        document.getElementById('uploadfiles').onclick = function() {
                            uploader.start();
                            return false;
                        };
                    },

                    Browse: function(up) {
                        // Called when file picker is clicked
                        log('[Browse]');
                    },

                    Refresh: function(up) {
                        // Called when the position or dimensions of the picker change
                        log('[Refresh]');
                    },

                    StateChanged: function(up) {
                        // Called when the state of the queue is changed
                        log('[StateChanged]', up.state == plupload.STARTED ? "STARTED" : "STOPPED");
                    },

                    QueueChanged: function(up) {
                        // Called when queue is changed by adding or removing files
                        log('[QueueChanged]');
                    },

                    OptionChanged: function(up, name, value, oldValue) {
                        // Called when one of the configuration options is changed
                        log('[OptionChanged]', 'Option Name: ', name, 'Value: ', value, 'Old Value: ', oldValue);
                    },

                    BeforeUpload: function(up, file) {
                        // Called right before the upload for a given file starts, can be used to cancel it if required
                        log('[BeforeUpload]', 'File: ', file);
                    },

                    UploadProgress: function(up, file) {
                        // Called while file is being uploaded
                        log('[UploadProgress]', 'File:', file, "Total:", up.total);
                    },

                    FileFiltered: function(up, file) {
                        // Called when file successfully files all the filters
                        log('[FileFiltered]', 'File:', file);
                    },

                    FilesAdded: function(up, files) {
                        // Called when files are added to queue
                        log('[FilesAdded]');

                        plupload.each(files, function(file) {
                            log('  File:', file);
                        });
                    },

                    FilesRemoved: function(up, files) {
                        // Called when files are removed from queue
                        log('[FilesRemoved]');

                        plupload.each(files, function(file) {
                            log('  File:', file);
                        });
                    },

                    FileUploaded: function(up, file, info) {
                        // Called when file has finished uploading
                        log('[FileUploaded] File:', file, "Info:", info);
                    },

                    ChunkUploaded: function(up, file, info) {
                        // Called when file chunk has finished uploading
                        log('[ChunkUploaded] File:', file, "Info:", info);
                    },

                    UploadComplete: function(up, files) {
                        // Called when all files are either uploaded or failed
                        log('[UploadComplete]');
                    },

                    Destroy: function(up) {
                        // Called when uploader is destroyed
                        log('[Destroy] ');
                    },

                    Error: function(up, args) {
                        // Called when error occurs
                        log('[Error] ', args);
                    }
                }

            });
            
            
            function log() {
                var str = "";

                plupload.each(arguments, function(arg) {
                    var row = "";

                    if (typeof(arg) != "string") {
                        plupload.each(arg, function(value, key) {
                            // Convert items in File objects to human readable form
                            if (arg instanceof plupload.File) {
                                // Convert status to human readable
                                switch (value) {
                                    case plupload.QUEUED:
                                        value = 'QUEUED';
                                        break;

                                    case plupload.UPLOADING:
                                        value = 'UPLOADING';
                                        break;

                                    case plupload.FAILED:
                                        value = 'FAILED';
                                        break;

                                    case plupload.DONE:
                                        value = 'DONE';
                                        break;
                                }
                            }

                            if (typeof(value) != "function") {
                                row += (row ? ', ' : '') + key + '=' + value;
                            }
                        });

                        str += row + " ";
                    } else {
                        str += arg + " ";
                    }
                });

                var log = $('#log');
                log.append(str + "\n");
                log.scrollTop(log[0].scrollHeight);
            }               
        });
    </script> -->