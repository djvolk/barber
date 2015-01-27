<?php
/* @var $this MainController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php $this->pageTitle = Yii::app()->name; ?>

<div class="home_container">
    <h2>
        <?php echo CHtml::link('<i class="fa fa-long-arrow-left"></i>', array(''), array('class' => 'back', 'style' => 'color:white;', 'page' => $page)); ?> 
        Новости
    </h2>	
</div><!--/ home_container-->
<div class="content_inner" style="overflow: auto">
    <div class="post-item" id="<?= $news['id'] ?>"> 
        <div class="post-thumb">
            <?php
            $date = new DateTime($news->date);
            if ($news->pic)
            {
                echo '<div class="post-date">'.$date->format('d').' '.$month[$date->format('n')].'</div>';
                echo '<img width=600 class="pic" src="'.Yii::app()->getBaseUrl().'/images/news/'.$news->pic.'" alt="" >';
            } else
                echo '<div class="post-date-without-pic">'.$date->format('d').' '.$month[$date->format('n')].'</div>';
            ?>					
        </div><!--/ post-thumb-->		
        <div class="post-title">
            <h3><?php echo $news->title; ?></h3>   
        </div><!--/ post-title-->	
        <div class="post-entry">
            <p>
                <?= $news->text ?>
            </p>
        </div><!--/ post-entty-->
        <div class="post-meta">
            <?php echo CHtml::link('Назад', array(), array('data-rel' => '11', 'class' => 'more back', 'style' => 'font-size: 12pt;', 'page' => $page)); ?>
            <!--            <div class="postmetadata">
                            <a href="#" class="post-like">25</a>
                            <a href="#" class="post-comments-icon">3</a>
                        </div>/ postmetadata-->
            <div class="clear"></div>
        </div><!--/ post-meta-->
    </div><!--/ post-item-->
</div><!-- form -->
<script type="text/javascript" src="js/jScrollPane.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.content_inner').jScrollPane();
        setTimeout(function () {
            $('.content_inner').jScrollPane();
        }, 50);

        $(".back").click(function () {
            $.ajax({
                type: "POST",
                url: '/index.php?r=main/news',
                cache: false,
                data: {'page': $(this).attr('page')},
                success: function (html) {
                    jQuery('#cont').html(html);
                }
            });
            return false;
        });
    });
</script>