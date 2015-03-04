<?php
/* @var $this MainController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php $this->pageTitle = 'Магазин - '.Yii::app()->name; ?>
<style>
    .product {
        text-align: center; 
        background:#2c2c2c; 
        -moz-border-radius:4px;
        -webkit-border-radius:4px;
        border-radius:4px;
    }
    .pic {
        margin-top: 10px;
        -moz-border-radius:4px;
        -webkit-border-radius:4px;
        border-radius:4px;
    }
</style>

<div class="home_container">
    <h2>
        <?php echo CHtml::link('<i class="fa fa-long-arrow-left"></i>', array(''), array('class' => 'back', 'style' => 'color:white;',)); ?> 
        <?= $category->name ?>
    </h2>	
</div><!--/ home_container-->
<div class="content_inner">
    <div class="gl_col_3">
        <?php
        if (isset($products))
            foreach ($products as $product)
            {
                ?>
                <div class="gallery-item picture-icon product"> 
                    <a class="gallery-zoom zoomer" data-rel="gallery_group" href="" product_id="<?= $product['id'] ?>">
                        <img  height="150" alt="" class="pic" src="/images/shop/products/<?= $product['image'] ?>" title="<?= $product['title'] ?>">
                        <h3 style="margin-top: 10px; font-size: 13pt;"><?= $product->title; ?></h3>
                    </a>
                    <?= $product->brief_description; ?>
                </div><!--/ gallery-item-->
                <?php
            } else
            echo '<h3>Извините, в этой категории пока нет товаров.</h3>';
        ?>	
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
            )
        ))
        ?>
    </div>
</div><!--/ content_inner-->
<script type="text/javascript">
    $(document).ready(function () {
//        $('.content_inner').jScrollPane();
//        setTimeout(function () {
//            $('.content_inner').jScrollPane();
//        }, 50);

        $(".zoomer").click(function () {
            $.ajax({
                type: "POST",
                url: 'shopProduct',
                cache: false,
                data: {'id': $(this).attr('product_id')},
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

        $(".back").click(function () {
            $.ajax({
                type: "POST",
                url: 'shop',
                cache: false,
                success: function (html) {
                    jQuery('#cont').html(html);
                }
            });
            return false;
        });
    });
</script>