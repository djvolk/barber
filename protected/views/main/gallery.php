<head>
    <title><?php echo 'Галерея - '.Yii::app()->name; ?></title>
    <meta name="keywords" content="<?php echo 'Галерея - '.Yii::app()->name; ?>"/>
    <meta name="description" content="<?php echo 'Галерея, примеры работ, работы мастера, фотографии, стрижка - '.Yii::app()->name; ?>"/>   
</head>

<div class="home_container">
    <h2>Галерея</h2>	
</div><!--/ home_container-->
<div class="content_inner">
    <?php if ($_GET['page'] == 1 or !$_GET['page']) echo $page->text; ?>
    <div class="content-divider"></div>
    <div class="gl_col_3">
        <?php
        if (isset($images))
            foreach ($images as $image)
            {
                ?>
        <div class="gallery-item picture-icon"> 
                    <a class="gallery-zoom zoomer" data-rel="gallery_group" href="images/gallery/photo/<?= $image['image'] ?>">
                        <img width="200"  alt="" class="pic" src="images/gallery/photo/<?= $image['image'] ?>" title="<?= $image['title'] ?>">
                    </a>	
                </div><!--/ gallery-item-->
            <?php } ?>	
    </div>
    <div class="clear"></div>
    <div class="text-center" style="margin-top: 20px;">
        <?php
        $this->widget('CLinkPager', array(
            'pages'         => $pages,
            'header'        => '',
            'nextPageLabel' => '>>',
            'prevPageLabel' => '<<',
            'cssFile'       => false,
            'htmlOptions'   => array(
                'id' => 'link_pager',
                'style' => 'bottom: 10px;'
            )
        ))
        ?>
    </div>
</div><!--/ content_inner-->
<script type="text/javascript">
    $(document).ready(function () {
        $('.content_inner').jScrollPane();
        setTimeout(function () {
            $('.content_inner').jScrollPane();
        }, 50);
	jQuery('.zoomer').fancybox({
		'overlayShow'	: true,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});
        $('#link_pager a').each(function () {
            $(this).click(function (ev) {
                ev.preventDefault();
                $.get(this.href, {ajax: true}, function (html) {
                    $('#cont').html(html);
                });
            });
        });
    });

</script>