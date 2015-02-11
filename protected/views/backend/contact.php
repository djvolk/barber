<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="/js/tinymce/tinymce.min.js" >"></script>
    <script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "textarea",
            language: 'ru',
            height: 200,
            plugins: 'textcolor preview code image link',
            toolbar: "fontselect fontsizeselect | forecolor preview code",
        });
    </script>

    <script>
        var myMap, myPlacemark, coords;

        ymaps.ready(init);

        function init() {

            myMap = new ymaps.Map('YMapsID', {//Определяем начальные параметры карты
                center: [<?= $contact['latlongcenter'] ?>],
                zoom: <?= $contact['mapzoom'] ?>
            });

            var SearchControl = new ymaps.control.SearchControl({noPlacemark: true}); //Определяем элемент управления поиск по карте		


            myMap.controls //Добавляем элементы управления на карту
                    .add(SearchControl)
                    .add('zoomControl')
                    .add('typeSelector')
                    .add('mapTools');

            coords = [<?= $contact['latlongmet'] ?>];

            //Определяем метку и добавляем ее на карту				
            myPlacemark = new ymaps.Placemark([<?= $contact['latlongmet'] ?>], {}, {preset: "twirl#redIcon", draggable: true});


            myMap.geoObjects.add(myPlacemark);

            //Отслеживаем событие перемещения метки
            myPlacemark.events.add("dragend", function (e) {
                coords = this.geometry.getCoordinates();
                savecoordinats();
            }, myPlacemark);

            //Отслеживаем событие щелчка по карте
            myMap.events.add('click', function (e) {
                coords = e.get('coordPosition');
                savecoordinats();
            });

            //Отслеживаем событие выбора результата поиска
            SearchControl.events.add("resultselect", function (e) {
                coords = SearchControl.getResultsArray()[0].geometry.getCoordinates();
                savecoordinats();
            });

            //Ослеживаем событие изменения области просмотра карты - масштаб и центр карты
            myMap.events.add('boundschange', function (event) {
                if (event.get('newZoom') != event.get('oldZoom')) {
                    savecoordinats();
                }
                if (event.get('newCenter') != event.get('oldCenter')) {
                    savecoordinats();
                }

            });

        }

        //Функция для передачи полученных значений в форму
        function savecoordinats() {
            var new_coords = [coords[0].toFixed(4), coords[1].toFixed(4)];
            myPlacemark.getOverlay().getData().geometry.setCoordinates(new_coords);
            document.getElementById("latlongmet").value = new_coords;
            document.getElementById("mapzoom").value = myMap.getZoom();
            var center = myMap.getCenter();
            var new_center = [center[0].toFixed(4), center[1].toFixed(4)];
            document.getElementById("latlongcenter").value = new_center;
        }
    </script>

    <style type="text/css" media="screen">
        #YMapsID {
            margin: 0;
            padding: 0;
            height: 100%;
        }
    </style>

    <?php $this->pageTitle = 'Контакты'; ?>  
</head>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'contact',
    'enableAjaxValidation' => false,
        ));
?>

<div class="page-header">
    <h1 style="display: inline;">Настройка контактов</h1> 
    <?php echo CHtml::submitButton('Сохранить', array('name' => 'Save', 'class' => 'btn btn-success', 'style' => 'float:right;')); ?>   
</div>


<div class="col-lg-6" style="padding-left: 0;">
    <div class="form-group">   
        <label>Телефон:</label> 
        <?php echo CHtml::textField('phone', $contact['phone'], array('class' => 'form-control')); ?>
    </div>
</div>

<div class="col-lg-6" style="padding-right: 0;">
    <div class="form-group">
        <label>E-mail:</label> 
        <?php echo CHtml::textField('email', $contact['email'], array('class' => 'form-control')); ?>  
    </div>
</div>                       

<div class="form-group">
    <label>Адрес:</label>
    <?php echo CHtml::textField('address', $contact['address'], array('class' => 'form-control')); ?>  
</div>

<div class="form-group">
    <label>Дополнительная информация:</label>
    <?php echo CHtml::textArea('info', $contact['info']); ?>
</div>

<div class="col-lg-6">
    <div class="form-group">
        <label>Вконтакте: </label>
        <?php echo CHtml::textField('vkontakte', $contact['vkontakte'], array('class' => 'form-control')); ?> 
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label>Facebook: </label>
        <?php echo CHtml::textField('facebook', $contact['facebook'], array('class' => 'form-control')); ?> 
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label>YouTube: </label>
        <?php echo CHtml::textField('youtube', $contact['youtube'], array('class' => 'form-control')); ?> 
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label>Instagram: </label>
        <?php echo CHtml::textField('instagram', $contact['instagram'], array('class' => 'form-control')); ?> 
    </div>
</div>

<div class="form-group">
    <label>Местоположение:</label>
</div>    
<div class="form-group">
    <div id="YMapsID"></div>       
</div>
<div class="col-lg-4 text-center">
    <div class="form-group">
        <label>Координаты метки: </label>
        <?php echo CHtml::textField('latlongmet', $contact['latlongmet'], array('id' => 'latlongmet', 'class' => 'form-control')); ?> 
    </div>
</div>
<div class="col-lg-4 text-center">
    <div class="form-group">
        <label>Масштаб: </label>
        <?php echo CHtml::textField('mapzoom', $contact['mapzoom'], array('id' => 'mapzoom', 'class' => 'form-control')); ?> 
    </div>
</div>
<div class="col-lg-4 text-center">
    <div class="form-group">
        <label>Центр карты: </label>
        <?php echo CHtml::textField('latlongcenter', $contact['latlongcenter'], array('id' => 'latlongcenter', 'class' => 'form-control')); ?> 
    </div>
</div>


<?php $this->endWidget(); ?>
