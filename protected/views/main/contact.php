<head>
    <title><?php echo 'Контакты - '.Yii::app()->name; ?></title>
    <meta name="keywords" content="<?php echo 'Контакты - '.Yii::app()->name; ?>"/>
    <meta name="description" content="<?php echo 'Контакты, Телефон, Адрес - '.Yii::app()->name; ?>"/>   
</head>

<script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
<style type="text/css" media="screen">
    #YMapsID {
        margin: 0;
        padding: 0;
        height: 100%;
    }
</style>

<div class="home_container">
    <h2>Контакты</h2>	
</div><!--/ home_container-->
<div class="content_inner">
    <h3 style="font-size: 1.8em;">Местоположение:</h3>
    <div class="map">
        <div id="YMapsID"></div>
    </div>
    <h3 style="font-size: 1.8em;">Контакты:</h3>
    <table cellspacing="10" style="font-size: 13pt; font-family: 'Pompadur'; font-weight: normal;">
        <tr>
            <td><h5 style="margin-bottom: 10px;">Адрес:</h5></td>
            <td><?= $contact['address'] ?></td>
        </tr>
        <tr>
            <td><h5 style="margin-bottom: 10px;">Телефон:</h5></td>
            <td><?= $contact['phone'] ?></td>
        </tr> 
        <tr>
            <td><h5 style="margin-bottom: 10px;">Email:</h5></td>
            <td><?= $contact['email'] ?></td>
        </tr> 
        <tr>
            <td><h5 style="margin-bottom: 10px;">Информация:</h5></td>
            <td><?= $contact['info'] ?></td>
        </tr> 
    </table>
</div>
<script type="text/javascript">

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

    $(document).ready(function () {
//        $('.content_inner').jScrollPane();
//        setTimeout(function () {
//            $('.content_inner').jScrollPane();
//        }, 50);
    });
</script>


