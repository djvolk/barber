<?php
/* @var $this MainController */
/* @var $dataProvider CActiveDataProvider */
?>
<?php $this->pageTitle = 'Восстановление пароля - '.Yii::app()->name; ?>

<div class="home_container">
    <h2>Восстановление пароля</h2>	
</div><!--/ home_container-->
<div class="content_inner">
    <?php
    if ($status == 'success')
    {
        ?>
        <div id="register">
            <span style="font-size:22px; font-family:'Pompadur'; color: green;">Вам был выслан новый пароль.</span>
        </div>
        <?php
    } elseif ($status == 'error')
    {
        ?>
        <div id = "register">
            <span style = "font-size:22px; font-family:'Pompadur'; color: red;">Произошла неизвестная ошибка. Попробуйте ещё раз, или свяжитесь с администратором.</span>
        </div>
    <?php } else
    {
        ?>
        <div class="register">
            <div class="row text-center" style="margin-left: 0;">
                <label style="width: 280px;">Введите свой телефон или e-mail:</label><br>
                <?php
                if ($status == 'fail')
                {
                    echo CHtml::TextField('text', $form['text'], array('class' => 'error', 'style' => 'margin-top: 20px;', 'id' => 'text')).'<br>';
                    echo '<div class="errorMessage" style="margin-top: 10px;">Такого пользователя не найдено.</div><br>';
                } else
                    echo CHtml::TextField('text', $form['text'], array('style' => 'margin-top: 20px;', 'id' => 'text')).'<br>';
                ?>
        <?php echo CHtml::button("ОТПРАВИТЬ", array('id' => 'butSend', 'name' => 'butSend', 'class' => 'button', 'style' => 'margin-top: 20px;',)); ?> 
            </div>
        </div>
<?php } ?>
</div><!--/ content_inner-->

<script type="text/javascript">
    $("#butSend").click(function () {
        $.ajax({
            type: "POST",
            url: '/index.php?r=main/forgotPassword',
            cache: false,
            data: {'text': $('#text').val()},
            success: function (html) {
                jQuery("#cont").html(html);
            }
        });
    });
</script>