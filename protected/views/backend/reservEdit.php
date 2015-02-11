<head>
    <link rel="stylesheet" type="text/css" href="/css/datepicker.css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script> 
    <script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
    <?php $this->pageTitle = 'Создать или редактировать запись'; ?>  
</head>



<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'reserv',
    'enableAjaxValidation' => false,
        ));
?>

<div class="page-header">
    <?php echo CHtml::link('<i class="fa fa-long-arrow-left"></i>', array('backend/reservAdmin'), array('class' => 'navbar-brand', 'style' => 'color:black;')); ?>
    <h1 style="display: inline;">Создать или редактировать запись</h1> 
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
                                echo '<li class="list-group-item list-group-item-danger" time="'.$time.'"><strong>';
                                echo ' <span class="badge" style="float:right;">Забронировано</span>';
                                echo '<i class="fa fa-fw fa-clock-o"></i> '.date('H:i', $time);
                                echo '</strong></li>';
                            } elseif ($status == 'new')
                            {
                                echo '<li class="list-group-item list-group-item-warning" time="'.$time.'"><strong>';
                                echo ' <span class="badge" style="float:right;">Не подтверждено</span>';
                                echo '<i class="fa fa-fw fa-clock-o"></i> '.date('H:i', $time);
                                echo '</strong></li>';
                            } elseif ($status == 'blocked')
                            {
                                echo '<li class="list-group-item" id='.$id.' time="'.$time.'"><strong>';
                                echo ' <span class="badge" style="float:right;">Заблокировано</span>';
                                echo '<i class="fa fa-fw fa-clock-o"></i> '.date('H:i', $time);
                                echo '</strong></li>';
                            } elseif ($time < time())
                            {
                                echo '<li class="list-group-item" id='.$id.' time="'.$time.'"><strong>';
                                echo ' <span class="badge" style="float:right;"></span>';
                                echo '<i class="fa fa-fw fa-clock-o"></i> '.date('H:i', $time);
                                echo '</strong></li>';
                            } else
                            {
                                echo '<a href="" class="list-group-item list-group-item-success time" time="'.$time.'"><strong>';
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

<div class="col-lg-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Пользователь:</h3>
        </div>

        <div class="panel-body">
            <div class="form-group">
                <?php
                if (isset($item))
                    echo CHtml::dropDownList('user', $item['user_id'], CHtml::listData(User::model()->findAll(), 'id', 'fullname'), array('class' => 'form-control', 'id' => 'users', 'style' => '', 'empty' => ''));
                else
                    echo CHtml::dropDownList('user', '', CHtml::listData(User::model()->findAll(), 'id', 'fullname'), array('class' => 'form-control', 'id' => 'users', 'style' => '', 'empty' => ''));
                ?>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Выберите услугу:</h3>
        </div>

        <div class="panel-body">
            <div class="form-group">
                <?php
                if (isset($item))
                    echo CHtml::dropDownList('operation', $item['operation_id'], CHtml::listData(Operations::model()->findAll(), 'id', 'name'), array('class' => 'form-control', 'id' => 'operations', 'style' => '', 'empty' => ''));
                else
                    echo CHtml::dropDownList('operation', '', CHtml::listData(Operations::model()->findAll(), 'id', 'name'), array('class' => 'form-control', 'id' => 'operations', 'style' => '', 'empty' => ''));
                ?>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-6" id="result">
    <?php
    if (isset($item))
    {
        ?>
        <div class="panel panel-green">
            <div class="panel-heading">
                <h3 class="panel-title">Запись:</h3>
            </div>

            <div class="panel-body" id="result_user" style="font-size: 14pt;">
                <?php echo CHtml::link('<h4>'.$item['surname'].' '.$item['firstname'], array('backend/ProfileAdmin', 'id' => $item['user_id']), array('style' => '')); ?>
                <span style="float:right;"><?= $item['phone'] ?></span></h4>
            </div>
            <div class="panel-body" id="result_operation" style="font-size: 14pt;">
                <blockquote class="text-success" style="font-size: 16pt;"><p><?= $item['name'] ?></p></blockquote>
                Примерная длительность: <strong><?= $item['duration'] ?> минут</strong><br>
                Примерная цена: <strong><?= $item['price'] ?> рублей</strong><br>
                <h3><em><small><?= $user_reserv['comment'] ?></small></em></h3>
            </div>
            <div class="panel-body" id="result_date" style="font-size: 14pt;">
                Когда: <strong><?= $item['date'] ?></strong><br>
                Время: <strong><?= $item['start'].' - '.$item['end'] ?></strong><br>
            </div> 
            <div class="panel-body" >               
                <?php echo CHtml::submitButton('Сохранить изменения', array('name' => 'Save', 'class' => 'btn btn-success', 'style' => 'float:right;')); ?> 
                <?php echo CHtml::link('Отменить', array('backend/reservAdmin'), array('class' => 'btn btn-danger', 'style' => 'color:white; float:right; margin-right: 10px;')); ?>
            </div>
        </div>
        <?php
    } else
    {
        ?>
        <div class="panel panel-green">
            <div class="panel-heading">
                <h3 class="panel-title">Записаться:</h3>
            </div>
            <div class="panel-body" id="result_user" style="font-size: 14pt;">
                <h2><em><small>Выберите пользователя</small></em></h2>
            </div>
            <div class="panel-body" id="result_operation" style="font-size: 14pt;">
                <h2><em><small>Выберите услугу</small></em></h2>
            </div>
            <div class="panel-body" id="result_date" style="font-size: 14pt;">
                <h2><em><small>Выберите время</small></em></h2>
            </div> 
            <div class="panel-body" >
                <?php echo CHtml::submitButton('Подтвердить', array('name' => 'Confirm', 'id' => 'butConfirm', 'class' => 'btn btn-success', 'disabled' => 'disabled', 'style' => 'float:right;')); ?>   
            </div>
        </div>
    <?php } ?>
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
                url: 'UpdateDate',
                cache: false,
                data: jQuery(this).parents("form").serialize(),
                success: function (html) {
                    jQuery("#date").html(html);
                }
            });
            $('#datepicker').blur();
            $('#datepicker').datepicker('hide');
        });

        $("#operations").change(function () {
            $.ajax({
                type: "POST",
                url: 'LoadOperation',
                cache: false,
                data: jQuery(this).parents("form").serialize(),
                success: function (html) {
                    jQuery("#result_operation").html(html);
                }
            });
        });

        $("#users").change(function () {
            $.ajax({
                type: "POST",
                url: 'LoadUser',
                cache: false,
                data: jQuery(this).parents("form").serialize(),
                success: function (html) {
                    jQuery("#result_user").html(html);
                }
            });
        });

        $(".time").click(function () {
            $.ajax({
                type: "POST",
                url: 'LoadDate',
                cache: false,
                data: {'time': $(this).attr('time')},
                success: function (html) {
                    jQuery("#result_date").html(html);
                }
            });
            return false;
        });
    });

    $(document).bind("ajaxComplete", function () {
        if ($('#date_success').val() == 'true' && $('#operation_success').val() == 'true' && $('#user_success').val() == 'true')
            $('#butConfirm').removeAttr("disabled");
        else
            $('#butConfirm').attr('disabled', 'disabled');
    });

</script>