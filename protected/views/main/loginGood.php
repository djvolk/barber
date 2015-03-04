<div class="row" align="middle">	
    <label style="font-size: 16px; width: 200px; text-align: middle;">
        <?php
        $user = User::model()->findByPk(Yii::app()->user->id);
        echo 'Вы зашли как: '.$user['phone'];
        ?></label>
</div>
<div>
    <?php
    if (Yii::app()->user->role == 'admin')
        echo CHtml::button('ЛИЧНЫЙ КАБИНЕТ', array('onclick' => 'js:document.location.href="backend/reservAdmin"', 'class' => 'button', 'style' => 'margin-left: 10px; ',));
    elseif (Yii::app()->user->role == 'user')
        echo CHtml::button('ЛИЧНЫЙ КАБИНЕТ', array('onclick' => 'js:document.location.href="backend/reserv"', 'class' => 'button', 'style' => 'margin-left: 10px; ',));
    echo CHtml::button("ВЫЙТИ", array('id' => 'butLogout', 'name' => 'butLogout', 'class' => 'button', 'style' => 'margin-left: 35px;',));
    ?>     
</div>

<script type="text/javascript">
    $("#butLogout").click(function () {
        $.ajax({
            type: "POST",
            url: 'logout',
            cache: false,
            data: jQuery(this).parents("form").serialize(),
            success: function (html) {
                jQuery("#login").html(html);
            }
        });
    });
</script>