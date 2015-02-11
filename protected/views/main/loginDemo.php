<div class="row" align="middle">
    <label style="font-size: 16px; width: 200px; text-align: middle;">Личный кабинет:</label>
</div>
<div class="row" align="middle">
    <?php
    echo CHtml::button('ДЕМО (АДМИН)', array('id' => 'butLoginAdmin', 'name' => 'butLoginAdmin', 'class' => 'button', 'style' => 'margin-left: 10px; ',));
    echo CHtml::button('ДЕМО (ПОЛЬЗОВАТЕЛЬ)', array('id' => 'butLoginUser', 'name' => 'butLoginUser', 'class' => 'button', 'style' => 'margin-left: 10px; ',));
    ?>     
</div>

<script type="text/javascript">
//    $("#butLogout").click(function () {
//        $.ajax({
//            type: "POST",
//            url: '/index.php?r=main/logout',
//            cache: false,
//            data: jQuery(this).parents("form").serialize(),
//            success: function (html) {
//                jQuery("#login").html(html);
//            }
//        });
//    });

    $("#butLoginAdmin").click(function () {
        $.ajax({
            type: "POST",
            url: 'loginAdmin',
            cache: false,
            data: jQuery(this).parents("form").serialize(),
            success: function (html) {
                //jQuery("#login").html(html);
                document.location.href = "backend/reservAdmin";
            }
        });
    });

    $("#butLoginUser").click(function () {
        $.ajax({
            type: "POST",
            url: 'loginUser',
            cache: false,
            data: jQuery(this).parents("form").serialize(),
            success: function (html) {
                //jQuery("#login").html(html);
                document.location.href = "backend/reserv";
            }
        });
    });
</script>