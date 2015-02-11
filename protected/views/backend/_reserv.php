<!-- ajax загружаемый div после изменения даты в календаре -->

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
                                    $status = 'reserved';
                                if ($time >= $reserv['time_start'] && $time < $reserv['time_end'] && $reserv['status'] == 'new')
                                    $status = 'new';
                                if ($time >= $reserv['time_start'] && $time < $reserv['time_end'] && $reserv['status'] == 'blocked')
                                    $status = 'blocked';
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
                            echo '<li class="list-group-item" time="'.$time.'"><strong>';
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
</script>



