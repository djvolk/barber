<?php
/* @var $this MainController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php $this->pageTitle = 'Главная - '.Yii::app()->name; ?>

<div class="home_container">
    <h2> <?php echo $code; ?></h2>		
</div><!--/ home_container-->
<div class="content_inner">
<div class="error">
<?php echo CHtml::encode($message); ?>
</div>
</div><!--/ content_inner-->

