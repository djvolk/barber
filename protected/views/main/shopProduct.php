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
        <?php echo CHtml::link('<i class="fa fa-long-arrow-left"></i>', array(''), array('class' => 'back', 'style' => 'color:white;', 'category_id' => $category->id)); ?>                   
        <?= $category->name ?>
    </h2>	
</div><!--/ home_container-->
<div class="content_inner">
    <div style="width: 30%; display: inline;">
        <a class="gallery-zoom zoomer"  data-rel="gallery_group" href="/images/shop/products/<?= $product['image'] ?>">
            <img  width="200" alt="" class="pic" style="vertical-align: top;" src="/images/shop/products/<?= $product['image'] ?>" title="<?= $product['title'] ?>">
        </a>
    </div>

    <div style="width: 60%; margin-left: 20px; display: inline-block;">
        <h3><?= $product->title ?></h3>
        <?= $product->description ?>
    </div>

</div><!--/ content_inner-->
<script type="text/javascript">
    $(document).ready(function () {
//        $('.content_inner').jScrollPane();
//        setTimeout(function () {
//            $('.content_inner').jScrollPane();
//        }, 50);

        jQuery('.zoomer').fancybox({
            'overlayShow': true,
            'transitionIn': 'elastic',
            'transitionOut': 'elastic'
        });

        $(".back").click(function () {
            $.ajax({
                type: "POST",
                url: 'shopProducts',
                cache: false,
                data: {'id': $(this).attr('category_id')},
                success: function (html) {
                    jQuery('#cont').html(html);
                }
            });
            return false;
        });
    });
</script>