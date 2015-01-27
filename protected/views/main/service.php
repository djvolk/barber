<?php
/* @var $this MainController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php $this->pageTitle = 'Услуги - '.Yii::app()->name; ?>

<div class="home_container">
    <h2>Услуги</h2>	
</div><!--/ home_container-->
<div class="content_inner">
    <?php echo $page->text; ?>
</div><!--/ content_inner-->
<script type="text/javascript">
    $(document).ready(function () {
        $('.content_inner').jScrollPane();
        setTimeout(function () {
            $('.content_inner').jScrollPane();
        }, 50);
    });
</script>

