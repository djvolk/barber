<!-- ajax загружаемый div сохранения новой услуги (с ошибками) -->

<div id="operation_form">
    <div class="form-group">
        <label>Название:</label>
        <?php echo CHtml::error($model, 'name', array('class' => 'alert alert-danger')); ?> 
        <?php echo CHtml::textField('name', $model['name'], array('class' => 'form-control', 'autofocus' => true,)); ?>  
    </div>
    <div class="col-lg-4" style="padding-left: 0;">
        <div class="form-group">
            <label>Время:</label>
            <?php echo CHtml::error($model, 'time', array('class' => 'alert alert-danger')); ?> 
            <?php echo CHtml::textField('time', $model['time'], array('class' => 'form-control', 'placeholder' => 'минуты')); ?>  
        </div>
    </div>
    <div class="col-lg-4" style="padding-right: 0;">    
        <div class="form-group">
            <label>Цена:</label>
            <?php echo CHtml::error($model, 'price', array('class' => 'alert alert-danger')); ?> 
            <?php echo CHtml::textField('price', $model['price'], array('class' => 'form-control', 'placeholder' => 'рубли')); ?>  
        </div>
    </div>
    <div class="col-lg-4" style="padding-right: 0;">    
        <div class="form-group">
            <label>Цена по карте:</label>
            <?php echo CHtml::error($model, 'discount_price', array('class' => 'alert alert-danger')); ?> 
            <?php echo CHtml::textField('discount_price', $model['discount_price'], array('class' => 'form-control', 'placeholder' => 'рубли')); ?>  
        </div>
    </div>    
    <div class="form-group">
        <label>Комментарий (необязательно):</label> 
        <?php echo CHtml::textArea('comment', $model['comment'], array('class' => 'form-control', 'style' => 'resize: none;')); ?>  
    </div>
</div>
