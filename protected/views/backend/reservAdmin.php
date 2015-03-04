<head>
    <link rel="stylesheet" type="text/css" href="/css/datepicker.back.css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script> 
    <script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="/js/bootstrap-datepicker.ru.js"></script>
    <?php $this->pageTitle = 'Управление записями'; ?>  
</head>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'reserv',
    'enableAjaxValidation' => false,
        ));
?>

<div class="page-header">
    <h1 style="display: inline;">Управление записями:</h1>
    <?php echo CHtml::link('Добавить запись', array('backend/reservEdit'), array('class' => 'btn btn-success', 'style' => 'float:right;')); ?>   
</div>

<div class="col-lg-6">

    <div class="panel panel-success"  style="display:none;" id="info">

    </div>

    <div class="panel panel-green">
        <div class="panel-heading">
            <h3 class="panel-title">Новые заявки:</h3>
        </div>

        <div class="panel-body">
            <div class="list-group">
                <?php
                if (isset($new_reserved))
                    foreach ($new_reserved as $item)
                    {
                        echo '<a href="#" class="list-group-item list-group-item-success info" id="'.$item['id'].'">';
                        echo '<h4 class="list-group-item-heading">'.$item['date'].' '.$item['time'].'</h4>';
                        echo ' <span class="badge" style="float:right;">'.$item['phone'].'</span>';
                        if (!empty($item['surname']) or !empty($item['firstname']))
                            echo ' <span class="badge" style="margin-right:50px;">'.$item['surname'].' '.$item['firstname'].'</span>';                               
                        echo '<p class="list-group-item-text">'.$item['name'].'</p>';
                        //echo '<p class="list-group-item-text">Длительность: '.$item['duration'].' мин. Цена: '.$item['price'].' руб.</p>';
                        echo '</a>';
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="panel panel-red">
        <div class="panel-heading">
            <h3 class="panel-title">Отмененные заявки:</h3>
        </div>

        <div class="panel-body">
            <div class="list-group">
                <?php
                if (isset($bad_reserved))
                    foreach ($bad_reserved as $item)
                    {
                        echo '<a href="#" class="list-group-item list-group-item-danger info" id="'.$item['id'].'">';
                        echo '<h4 class="list-group-item-heading">'.$item['date'].' '.$item['time'].'</h4>';
                        echo ' <span class="badge" style="float:right;">'.$item['surname'].' '.$item['firstname'].'</span>';
                        echo '<p class="list-group-item-text">'.$item['name'].'</p>';
                        //echo '<p class="list-group-item-text">Длительность: '.$item['duration'].' мин. Цена: '.$item['price'].' руб.</p>';
                        echo '</a>';
                    }
                ?>
            </div>
        </div>
    </div>
</div>



<div class="col-lg-6" id="date">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Выберите дату:</h3>
        </div>

        <div class="panel-body">
            <div class="form-group input-group">
                <?php echo CHtml::textField('date', date("d-m-Y", $date['num']), array('class' => 'form-control', 'id' => 'datepicker')); ?>  
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title lead"><i class="fa fa-calendar-o fa-fw"></i> <strong><?php echo $date['string']; ?></strong></h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        <?php
                        for ($time = $date['time_start']; $time <= $date['time_end']; $time = $time + ($date['period'] * 60))
                        {
                            $status = 'free';
                            if (isset($reserved))
                                foreach ($reserved as $reserv)
                                {
                                    if ($time >= $reserv['time_start'] && $time < $reserv['time_end'] && $reserv['status'] == 'reserved')
                                    {
                                        $status = 'reserved';
                                        $id = $reserv['id'];
                                    }
                                    if ($time >= $reserv['time_start'] && $time < $reserv['time_end'] && $reserv['status'] == 'new')
                                    {
                                        $status = 'new';
                                        $id = $reserv['id'];
                                    }
                                    if ($time >= $reserv['time_start'] && $time < $reserv['time_end'] && $reserv['status'] == 'blocked')
                                    {
                                        $status = 'blocked';
                                        $id = $reserv['id'];
                                    }
                                }

                            if ($status == 'reserved')
                            {
                                echo '<a href="" class="list-group-item list-group-item-danger time" id='.$id.' time="'.$time.'"><strong>';
                                echo ' <span class="badge" style="float:right;">Забронировано</span>';
                                echo '<i class="fa fa-fw fa-clock-o"></i> '.date('H:i', $time);
                                echo '</strong></a>';
                            } elseif ($status == 'new')
                            {
                                echo '<a href="" class="list-group-item list-group-item-warning time" id='.$id.' time="'.$time.'"><strong>';
                                echo ' <span class="badge" style="float:right;">Не подтверждено</span>';
                                echo '<i class="fa fa-fw fa-clock-o"></i> '.date('H:i', $time);
                                echo '</strong></a>';
                            } elseif ($status == 'blocked')
                            {
                                echo '<a href="" class="list-group-item time" id='.$id.' time="'.$time.'"><strong>';
                                echo ' <span class="badge" style="float:right;">Заблокировано</span>';
                                echo '<i class="fa fa-fw fa-clock-o"></i> '.date('H:i', $time);
                                echo '</strong></a>';
                            } elseif ($time < time())
                            {
                                echo '<li class="list-group-item" id='.$id.' time="'.$time.'"><strong>';
                                echo ' <span class="badge" style="float:right;"></span>';
                                echo '<i class="fa fa-fw fa-clock-o"></i> '.date('H:i', $time);
                                echo '</strong></li>';
                            } else
                            {
                                echo '<a href="" class="list-group-item list-group-item-success time" id="clear" time="'.$time.'"><strong>';
                                echo ' <span class="badge" style="float:right;"></span>';
                                echo '<i class="fa fa-fw fa-clock-o"></i> '.date('H:i', $time);
                                echo '</strong></a>';
                            }
                        }
                        ?>      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(function () {
        $('#datepicker').datepicker({
            language: 'ru',
            format: 'dd-mm-yyyy',
            weekStart: 1,
        }).on('changeDate', function () {
            $.ajax({
                type: "POST",
                url: 'UpdateDateAdmin',
                cache: false,
                data: jQuery(this).parents("form").serialize(),
                success: function (html) {
                    jQuery("#date").html(html);
                }
            });
            $('#datepicker').blur();
            $('#datepicker').datepicker('hide');
        });

        $(".info").click(function () {
            $.ajax({
                type: "POST",
                url: 'LoadReservAdmin',
                cache: false,
                data: {'id': $(this).attr('id')},
                success: function (html) {
                    jQuery("#info").html(html);
                    $("#info").show();
                }
            });
            return false;
        });

        $(".time").click(function () {
            $.ajax({
                type: "POST",
                url: 'LoadTimeAdmin',
                cache: false,
                data: {'id': $(this).attr('id'), 'time': $(this).attr('time')},
                success: function (html) {
                    jQuery("#info").html(html);
                    $("#info").show();
                }
            });
            return false;
        });
    });

    function cancel_click($id) {
        $.ajax({
            type: "POST",
            url: 'CancelReservAdmin',
            cache: false,
            data: {'id': $id},
            success: function (html) {
                jQuery("#button").html(html);
            }
        });
        return false;
    }
    ;

</script>
