<script type="text/javascript">
        jQuery(function ($) {
            $.ajax( {
                type: "POST",
                url: '/index.php?r=main/login',
                cache: false,
                data: jQuery(this).parents("form").serialize(),
                success: function (html) {
                    jQuery("#login").html(html);
                }
        });
    });
</script>

<?php $this->pageTitle = 'Регистрация - '.Yii::app()->name; ?>

<div id="register">
            <span style="font-size:20px; font-family:'Pompadur';">    Поздравляем, <?php echo $form->name.' '.$form->surname; ?>, Вы успешно зарегистрировались! Теперь вы можете перейти в 
            <?php echo CHtml::link('личный кабинет', array('backend/index'), array('style' =>'font-size:20px;')); ?>.</span>
</div><!--/ content_inner-->

