<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script> 
    <?php $this->pageTitle = 'Управление картами'; ?>  
</head>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'cards',
    'enableAjaxValidation' => false,
        ));
?>
<div class="page-header">
    <h1 style="display: inline;">Управление картами</h1>
    <?php echo CHtml::button('Добавить карту', array('onclick' => '$("#newCard").toggle();', 'class' => 'btn btn-success', 'style' => 'float:right;')); ?>   
</div>

<div class="panel panel-success" id="newCard" style="<?php if (!$model->hasErrors()) echo 'display: none;'; ?>">
    <div class="panel-heading">
        <h3 class="panel-title">Новая карта:</h3>
    </div>
    <div class="panel-body">
        <div class="col-lg-4">
            <div class="form-group">
                <label>Номер: </label>
                <?php echo CHtml::textField('num', $model->num, array('class' => 'form-control', 'id' => 'num')); ?> 
                <?php echo CHtml::error($model, 'num', array('class' => 'alert alert-danger', 'style' => 'margin-top:10px;')); ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Пользователь: </label>
                <?php echo CHtml::dropDownList('user_id', $model->user_id, CHtml::listData($users, 'id', 'fullname'), array('class' => 'form-control', 'style' => '', 'empty' => '', 'id' => 'user')); ?>
                <?php echo CHtml::error($model, 'user_id', array('class' => 'alert alert-danger', 'style' => 'margin-top:10px;')); ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Статус: </label>
                <?php echo CHtml::dropDownList('status', $model->status, array('free' => 'Свободная', 'connect' => 'Подключена'), array('class' => 'form-control', 'style' => '', 'id' => 'status')); ?> 
                <?php echo CHtml::error($model, 'status', array('class' => 'alert alert-danger', 'style' => 'margin-top:10px;')); ?>
            </div>
        </div>
        <?php echo CHtml::submitButton('Добавить', array('name' => 'addCard', 'class' => 'btn btn-success', 'style' => 'float:right;')); ?>   
        <?php echo CHtml::button('Отмена', array('id' => 'cancel', 'class' => 'btn btn-danger', 'style' => 'float:right;  margin-right: 10px;')); ?>   
    </div>
</div>

<?php
if (isset($cards))
    foreach ($cards as $card)
    {
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php
                        echo '<span style="font-size: 16px;">Номер: <strong>'.$card['num'].'</strong></span>';

                        if ($card['status'] == 'free')
                            echo '<span style="margin-left:20px; font-size: 16px;">Статус: <strong>Свободная</strong></span>';
                        elseif ($card['status'] == 'connect')
                            echo '<span style="margin-left:20px; font-size: 16px;">Статус: <strong>Подключена</strong></span>';

                        if (!empty($card['user_id']))
                        {
                            $user = User::model()->findByPk($card['user_id']);
                            echo '<span style="margin-left:20px; font-size: 16px;">Пользователь: '.CHtml::link('<strong>'.$user['surname'].' '.$user['name'].'</strong></span>', array('backend/UserAdmin', 'id' => $user['id']), array('style' => ''));
                        }
                        echo CHtml::link('Удалить', array('backend/DeleteCard', 'id' => $card['id']), array('class' => 'btn btn-xs btn-danger', 'style' => 'float:right;', 'confirm' => 'Хотите удалить карту?'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

<div class="text-center">
    <?php
    $this->widget('CLinkPager', array(
        'pages'                => $pages,
        'header'               => '',
        'nextPageLabel'        => '>>',
        'prevPageLabel'        => '<<',
        'firstPageLabel'       => 'Первая',
        'lastPageLabel'        => 'Последняя',
        'selectedPageCssClass' => 'active',
        'hiddenPageCssClass'   => 'disabled',
        'htmlOptions'          => array(
            'class' => 'pagination',
            'style' => 'margin-bottom: 0px;',
        )
    ))
    ?>
</div>
<style>
    ul.pagination .first, ul.pagination .last {
        display: none;
    }
</style>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(function () {
        $("#cancel").click(function () {
            $("#num").val('');
            $("#user").val('');
            $("#status").val('');
            $("#newCard").hide();
        });
    });


</script>    