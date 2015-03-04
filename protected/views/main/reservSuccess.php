<title><?php echo 'Услуги - '.Yii::app()->name; ?></title>
<meta name="keywords" content="<?php echo 'Услуги - '.Yii::app()->name; ?>"/>
<meta name="description" content="<?php echo 'Услуги - '.Yii::app()->name; ?>"/>  
<script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
<style type="text/css" media="screen">
    #YMapsID {
        margin: 0;
        padding: 0;
        height: 100%;
    }
</style>
<div class="home_container">
    <h2>ВЫ ЗАПИСАЛИСЬ В САЛОН</h2>	
</div><!--/ home_container-->
<div class="content_inner">
    <div class="box text-center">
        <span class="pane" style="float:left;">Ваша заявка:</span><br>
        <h3 class="big"><?= $reserv['name'] ?></h3>

        <div class="one_half option" style="margin-top: 0px;">
            <span style="float: right; "> Примерная длительность: </span>
        </div>
        <div class="one_half_last option">
            <span style="float: left; "><?= $reserv['duration'] ?> минут</span>
        </div>       

        <div class="one_half option" style="margin-top: 0px;">
            <span style="float: right; ">Примерная цена:</span>
        </div>
        <div class="one_half_last option">
            <span style="float: left; "><?= $reserv['price'] ?> рублей</span>
        </div> 

        <div class="one_half option" style="margin-top: 0px;">
            <span style="float: right; ">Когда: </span>
        </div>
        <div class="one_half_last option">
            <span style="float: left; "><?= $reserv['date'] ?></span>
        </div> 

        <div class="one_half option" style="margin-top: 0px;">
            <span style="float: right; ">Время: </span>
        </div>
        <div class="one_half_last option">
            <span style="float: left; "><?= $reserv['start'].' - '.$reserv['end'] ?></span>
        </div> 
<!--<h3><em><small>бла бла бла</small></em></h3>-->

        <h2 style="font-size:22px; color: #e9403b; margin-top: 20px;">Вам перезвонят в течении 10-15 минут.</h2>
    </div>

    <div class="clear" style="margin-bottom: 20px;"></div>
    <div class="option text-center">
        Вы можете пройти <a href="#" class="href" id="hrefReg">РЕГИСТРАЦИЮ</a> и получать SMS уведомления. А так же упростить ONLINE бронирование.
    </div>   

    <div class="clear" style="margin-bottom: 20px;"></div>
    <h3 style="font-size: 1.8em;">Мое расположение:</h3>
    <div class="map">
        <div id="YMapsID"></div>
    </div>
</div><!--/ content_inner-->
<script type="text/javascript">
    $(document).ready(function () {

        $("#hrefReg").click(function () {
            $.ajax({
                type: "POST",
                url: 'OpenRegistration',
                cache: false,
                data: jQuery(this).parents("form").serialize(),
                success: function (html) {
                    jQuery("#cont").html(html);
                }
            });
        });

        var myMap, myPlacemark, coords;
        ymaps.ready(init);

        function init() {
            myMap = new ymaps.Map('YMapsID', {//Определяем начальные параметры карты
                center: [<?= $contact['latlongcenter'] ?>],
                zoom: <?= $contact['mapzoom'] ?>
            });
            var SearchControl = new ymaps.control.SearchControl({noPlacemark: true}); //Определяем элемент управления поиск по карте		
            myMap.controls //Добавляем элементы управления на карту
                    .add('zoomControl')
                    .add('typeSelector')
                    .add('mapTools');

            coords = [<?= $contact['latlongmet'] ?>];

            //Определяем метку и добавляем ее на карту				
            myPlacemark = new ymaps.Placemark([<?= $contact['latlongmet'] ?>], {}, {preset: "twirl#redIcon", draggable: true});
            myMap.geoObjects.add(myPlacemark);
        }
    });
</script>
