<?php
/* @var $this MainController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php $this->pageTitle = 'Магазин - '.Yii::app()->name; ?>

<div class="home_container">
    <h2>Магазин</h2>	
</div><!--/ home_container-->
<div class="content_inner">
    <?php echo $page->text; ?>
    <div class="content-divider"></div>
    <div class="gl_col_3">
        <?php
        if (isset($categories))
            foreach ($categories as $category)
            {
                ?>
                <div class="gallery-item picture-icon"  style="text-align: center;"> 
                    <a class="gallery-zoom zoomer" data-rel="gallery_group" href="" category_id="<?=$category['id']?>">
                        <img width="199" height="154" alt="" class="pic" src="/images/shop/category/<?= $category['image'] ?>" title="<?= $category['name'] ?>">
                        <h3 style="margin-top: 5px; font-size: 13pt;"><?= $category->name; ?></h3>
                    </a>	
                </div><!--/ gallery-item-->
            <?php } ?>	
    </div>
    <div class="clear"></div>
</div><!--/ content_inner-->
<script type="text/javascript">
    $(document).ready(function () {
        $(".zoomer").click(function () {
            $.ajax({
                type: "POST",
                url: '/index.php?r=main/shopProducts',
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