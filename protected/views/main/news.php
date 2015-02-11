<head>
    <title><?php echo 'Новости - '.Yii::app()->name; ?></title>
    <meta name="keywords" content="<?php echo 'Новости - '.Yii::app()->name; ?>"/>
    <meta name="description" content="<?php echo 'Новости - '.Yii::app()->name; ?>"/>   
</head>

<div class="home_container">
    <h2>Новости</h2>	
</div><!--/ home_container-->
<div class="content_inner" style="overflow: auto;"> 
    <?php
    if ($news)
        foreach ($news as $new)
        {
            ?>
            <div class="post-item" id="<?= $new['id'] ?>"> 
                <div class="post-thumb">
                    <?php
                    $date = new DateTime($new->date);
                    if ($new->pic)
                    {
                        echo '<div class="post-date">'.$date->format('d').' '.$month[$date->format('n')].'</div>';
                        echo CHtml::link('<img width=600 class="pic" src="'.Yii::app()->getBaseUrl().'/images/news/'.$new->pic.'" alt="" >', array(), array('data-rel' => '11', 'news_id' => $new['id'], 'class' => 'load'));
                    } else
                        echo '<div class="post-date-without-pic">'.$date->format('d').' '.$month[$date->format('n')].'</div>';
                    ?>					
                </div><!--/ post-thumb-->		
                <div class="post-title">
                    <h3><?php echo CHtml::link($new->title, array(), array('data-rel' => '11', 'style' => 'font-size: 14pt;', 'news_id' => $new['id'], 'class' => 'load')); ?></h3>   
                </div><!--/ post-title-->	
                <div class="post-entry">
                    <p>
                        <?= mb_strimwidth($new->text, 0, 300, "..."); ?>
                    </p>
                </div><!--/ post-entty-->
                <div class="post-meta">
                    <?php echo CHtml::link('Читать далее', array(), array('data-rel' => '11', 'class' => 'more load', 'style' => 'font-size: 12pt;', 'news_id' => $new['id'])); ?>
                    <!--                    <div class="postmetadata">
                                            <a href="#" class="post-like">25</a>
                                            <a href="#" class="post-comments-icon">3</a>
                                        </div>/ postmetadata-->
                    <div class="clear"></div>
                </div><!--/ post-meta-->
            </div><!--/ post-item-->
        <?php } ?>
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
            )
        ))
        ?>
    </div>
</div><!-- form -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.content_inner').jScrollPane();
        setTimeout(function () {
            $('.content_inner').jScrollPane();
        }, 50);

        $(".load").click(function () {
            $.ajax({
                type: "POST",
                url: 'newsRead',
                cache: false,
                data: {'id':$(this).attr('news_id'), 'page':$('#link_pager li.selected a').html()},
                success: function (html) {
                    jQuery('#cont').html(html);
                }
            });
            return false;
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

//    $(window).bind("ajaxComplete", function () {    
//        $('.content_inner').jScrollPane({
//					verticalDragMinHeight: 80,
//					verticalDragMaxHeight: 80
//				}).reinitialise();
//    });
</script>