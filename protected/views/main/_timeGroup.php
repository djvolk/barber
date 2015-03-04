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
        echo '<a class="list-group-item list-group-item-danger not-active" time="'.$time.'"><strong>';
        echo ' <span class="badge" style="float:right;">Забронировано</span>';
        echo '<i class="fa fa-lg fa-clock-o" style="margin-right: 20px;"></i> '.date('H:i', $time);
        echo '</strong></a>';
    } elseif ($status == 'new')
    {
        echo '<a class="list-group-item list-group-item-warning not-active" time="'.$time.'"><strong>';
        echo ' <span class="badge" style="float:right;">Не подтверждено</span>';
        echo '<i class="fa fa-lg fa-clock-o" style="margin-right: 20px;"></i> '.date('H:i', $time);
        echo '</strong></a>';
    } elseif ($status == 'blocked')
    {
        echo '<a class="list-group-item not-active" id='.$id.' time="'.$time.'"><strong>';
        echo ' <span class="badge" style="float:right;">Заблокировано</span>';
        echo '<i class="fa fa-lg fa-clock-o" style="margin-right: 20px;"></i> '.date('H:i', $time);
        echo '</strong></a>';
    } elseif ($time < time())
    {
        echo '<a class="list-group-item not-active" id='.$id.' time="'.$time.'"><strong>';
        echo ' <span class="badge" style="float:right;"></span>';
        echo '<i class="fa fa-lg fa-clock-o" style="margin-right: 20px;"></i> '.date('H:i', $time);
        echo '</strong></a>';
    } else
    {
        echo '<a href="" class="list-group-item list-group-item-success time" time="'.$time.'"><strong>';
        echo ' <span class="badge" style="float:right;"></span>';
        echo '<i class="fa fa-lg fa-clock-o" style="margin-right: 20px;"></i> '.date('H:i', $time);
        echo '</strong></a>';
    }
}
?> 

<script type="text/javascript">
    $(document).ready(function () {

//---------------------TIME----------------------//

        $(".time").click(function () {
            var $date = new Date($(this).attr('time') * 1000);
            var $hours = $date.getHours();
            var $minutes = $date.getMinutes();
            if ($hours < 10)
                $hours = '0' + $hours;
            if ($minutes < 10)
                $minutes = '0' + $minutes;
            $('#timeLabel').html($hours + ':' + $minutes);
            $('#timeLabel').attr('time', $(this).attr('time'));

            if ($('#phoneLabel').html() == '')
            {
                $('#phone').click();
                $('#phoneInput').focus().setCursorPosition(2);
            } else {
                $('#time').click();
                $('#confirm').fadeIn(300);
                $('#confirm_span').fadeIn(300);
            }
            $("body").animate({"scrollTop": 0}, 300);
            return false;
        });

        var $info = '<span class="info" style="margin-left: 18px; float:right; font-style: italic;">учтите, операция будет занимать не меньше часа</span>';
        $(".time").hover(function () {
            $(this).append($info);
        });

        $(".time").mouseleave(function () {
            $('.info').remove();
        });
    });

</script>
