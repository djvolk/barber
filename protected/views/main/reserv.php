<title><?php echo 'Запись - '.Yii::app()->name; ?></title>
<meta name="keywords" content="<?php echo 'Бронирование, Запись - '.Yii::app()->name; ?>"/>
<meta name="description" content="<?php echo 'ONLINE Запись - '.Yii::app()->name; ?>"/> 

<script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/js/bootstrap-datepicker.ru.js"></script>
<script type="text/javascript" src="/js/jquery.mask.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/datepicker.front.css" />

<div class="home_container">
    <h1>ЗАПИСЬ В САЛОН</h1>	
</div><!--/ home_container-->
<div class="content_inner">
    <ul class="accordion ui-accordion ui-widget ui-helper-reset ui-accordion-icons" role="tablist">
        <li class="ui-accordion-li-fix" style="margin-bottom: 20px;">
            <a href="#" id="operation" class="opener ui-accordion-header ui-helper-reset ui-state-default ui-corner-all selected" role="tab" aria-expanded="false" aria-selected="false" tabindex="0">
                <span class="pane">ШАГ 1: ВЫБЕРИТЕ УСЛУГУ</span>
                <span class="input-group-addon"><i class="fa fa-child fa-lg" style="float: right;"></i></span>
                <?php echo CHtml::label($operation, 'operation', array('id' => 'operationLabel', 'class' => 'show')); ?>
            </a>
            <div class="slide-holder ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" role="tabpanel" style="display: none; overflow: visible; padding-top: 8px; padding-bottom: 8px;">
                <div class="slide text-center">                 
                    <?php
                    if (isset($operations))
                        foreach ($operations as $operation)
                        {
                            echo CHtml::button($operation['name'], array('class' => 'operationButton', 'style' => 'width: 270px; margin: 10px 10px 10px 10px;',));
                        }
                    ?>
        <!-- <button class="superButton button--winona" data-text="стрижка + окраска"><span>+</span></button>-->
                </div><!-- end slide-holder -->
            </div><!-- end slide -->
        </li>
        <li class="ui-accordion-li-fix" style="margin-bottom: 20px;">
            <a href="#" id="calendar" class="opener ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" role="tab" aria-expanded="false" aria-selected="false" tabindex="0">
                <span class="pane">ШАГ 2: ВЫБЕРИТЕ ДЕНЬ</span>
                <span class="input-group-addon"><i class="fa fa-calendar fa-lg" style="float: right;"></i></span>
                <?php echo CHtml::label($date['string'], 'date', array('id' => 'dateLabel', 'time' => $date['num'], 'class' => 'show')); ?>
            </a>
            <div class="slide-holder ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" role="tabpanel" style="display: none; overflow: visible; padding-top: 8px; padding-bottom: 8px;">
                <div class="slide calendar">
                    <div id="datepicker" style="margin-left: 180px;"></div>
                </div><!-- end slide-holder -->
            </div><!-- end slide -->
        </li>           
        <li class="ui-accordion-li-fix" style="margin-bottom: 20px;">
            <a href="#" id="time" class="opener ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" role="tab" aria-expanded="false" aria-selected="false" tabindex="-1">
                <span class="pane">ШАГ 3: ВЫБЕРИТЕ ВРЕМЯ</span>
                <span class="input-group-addon"><i class="fa fa-clock-o fa-lg" style="float: right;"></i></span>
                <?php echo CHtml::label('', 'time', array('id' => 'timeLabel', 'class' => 'show', 'time' => '')); ?>
            </a>
            <div class="slide-holder ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" role="tabpanel" style="display: none; overflow: visible; padding-top: 8px; padding-bottom: 8px;">
                <div class="slide">
                    <div class="error text-center"></div>
                    <div class="list-group" id="time-group">
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
                    </div>
                </div><!-- end slide-holder -->
            </div><!-- end slide -->
        </li>
        <li class="ui-accordion-li-fix">
            <a href="#" id="phone" class="opener ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" role="tab" aria-expanded="false" aria-selected="false" tabindex="0">
                <span class="pane">ШАГ 4: ВВЕДИТЕ ТЕЛЕФОН</span>
                <span class="input-group-addon"><i class="fa fa-phone fa-lg" style="float: right;"></i></span>
                <?php
                $phone = Yii::app()->request->cookies['phone']->value;
                if (!isset($phone))
                {
                    $label = '';
                    $phone = '+7';
                } else
                    $label = $phone;
                echo CHtml::label($label, 'phone', array('id' => 'phoneLabel', 'class' => 'show'));
                ?>
            </a>
            <div class="slide-holder ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" role="tabpanel" style="display: none; overflow: visible; padding-top: 8px; padding-bottom: 8px;">
                <div class="slide text-center">
                    <?php echo CHtml::textField('phone', $phone, array('id' => 'phoneInput', 'class' => 'phone')); ?>
                    <?php echo CHtml::button('ОК', array('id' => 'phoneButton', 'class' => 'phoneButton disabled',)); ?>
                </div><!-- end slide-holder -->
            </div><!-- end slide -->
        </li>
    </ul>

    <form method="POST" action="">
        <div class="text-center">
            <input id="confirm" class="want" style="display: none; font-size: 24px; margin-top: 20px; margin-bottom: 20px;" type="button" value="ЗАПИСАТЬСЯ" />
            <label id="confirm_span" class="option" style="display: none; font-size: 20px;">ON-LINE запись действительна только после подтверждения администратором</label>
            <input type="hidden" name="operation" id="operation_input" value="">
            <input type="hidden" name="date" id="date_input" value="">
            <input type="hidden" name="time" id="time_input" value="">
            <input type="hidden" name="phone" id="phone_input" value="">
        </div>             
    </form>

    <!--    <div class="content-divider"></div>-->

</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.content_wrapper').height(1200);
        $("body").animate({"scrollTop": 0}, 300);
//---------------------OPERATION----------------------//

        $(".operationButton").click(function () {
            $('#operationLabel').html($(this).val());
            if ($('#timeLabel').html() == '')
                $('#time').click();
            else if ($('#phoneLabel').html() == '')
            {
                $('#phone').click();
                $('#phoneInput').focus().setCursorPosition(2);
            } else
            {
                $('#operation').click();
                $('#confirm').fadeIn(300);
                $('#confirm_span').fadeIn(300);
            }
            $("body").animate({"scrollTop": 0}, 300);
            return false;
        });

//---------------------CALENDAR----------------------//

        $("#calendar").click(function () {
            var $date = new Date($('#dateLabel').attr('time') * 1000);
            $('#datepicker').datepicker('update', new Date($date.getFullYear(), $date.getMonth(), $date.getDate()));
        });

        var $start_date = new Date($('#dateLabel').attr('time') * 1000);
        $('#datepicker').datepicker({
            weekStart: 1,
            todayBtn: "linked",
            language: "ru",
            format: 'dd-mm-yyyy',
            startDate: $start_date,
        }).on('changeDate', function () {
            var $date = new Date($('#datepicker').datepicker('getDate'));
            var $day = $date.getDate();
            if ($day < 10)
                $day = '0' + $day;
            $('#dateLabel').attr('time', $date.getTime() / 1000);
            $('#dateLabel').html($day + ' ' + getMonth($date.getMonth()) + ' ' + $date.getFullYear());

            $.ajax({
                type: "POST",
                url: 'UpdateTimeGroup',
                cache: false,
                data: {'date': ($date.getTime() / 1000)},
                success: function (html) {
                    jQuery("#time-group").html(html);
                }
            });

            $('#time').click();
            $("body").animate({"scrollTop": 0}, 300);
            return false;
        });

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
            }
            else if ($('#operationLabel').html() == '')
            {
                $('#operation').click();
            }
            else
            {
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

//---------------------PHONE----------------------//

        $('#phoneInput').mask("+70000000000");
        $('#phoneInput').bind("change keyup input click", function () {

            if (this.value.length == 12)
                $('#phoneButton').removeClass("disabled");
            else
                $('#phoneButton').addClass("disabled");
        });

        $('#phone').click(function () {
            var $phone = $('#phoneInput').val();
            if ($phone.length == 12)
                $('#phoneButton').removeClass("disabled");
            else
                $('#phoneButton').addClass("disabled");
        });


        $('#phoneButton').click(function () {
            $('#phoneLabel').html($('#phoneInput').val());
            if ($('#timeLabel').html() == '')
            {
                $('#time').click();
            }
            else if ($('#operationLabel').html() == '')
            {
                $('#operation').click();
            }
            else
            {
                $('#phone').click();
                $('#confirm').fadeIn(300);
                $('#confirm_span').fadeIn(300);
            }
            $("body").animate({"scrollTop": 0}, 300);
            return false;
        });

//----------------------CONFIRM_----------------------//

        $("#confirm").click(function () {
            $('#operation_input').val($('#operationLabel').html());
            $('#date_input').val($('#dateLabel').attr('time'));
            $('#time_input').val($('#timeLabel').attr('time'));
            $('#phone_input').val($('#phoneLabel').html());

            $.ajax({
                type: "POST",
                url: 'SaveReserv',
                cache: false,
                data: jQuery(this).parents("form").serialize(),
                dataType: 'json',
                success: function (data) {
                    if (data.status == 'success')
                        jQuery("#cont").html(data.html);
                    else
                    {
                        $('#time').click();
                        jQuery(".error").html(data.html);
                    }
                }
            });
        });
    });

//---------------------ACCORDION----------------------//

    if ($('ul.accordion').length) {
        $('ul.accordion').accordion({animate: 300, active: '.selected', autoHeight: false, header: ".opener", collapsible: true, event: "click"});
    }

//---------------------OTHERS----------------------//

    $.fn.setCursorPosition = function (pos) {
        this.each(function (index, elem) {
            if (elem.setSelectionRange) {
                elem.setSelectionRange(pos, pos);
            } else if (elem.createTextRange) {
                var range = elem.createTextRange();
                range.collapse(true);
                range.moveEnd('character', pos);
                range.moveStart('character', pos);
                range.select();
            }
        });
        return this;
    };

    function getMonth($month)
    {
        var arr = ["января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"];
        return arr[$month];
    }
</script>
