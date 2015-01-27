<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script> 
    <?php $this->pageTitle = 'Профиль - '.Yii::app()->name; ?>
</head>

<?php $form = $this->beginWidget('CActiveForm'); ?>
<div class="page-header">
    <h1 style="display: inline;">Профиль</h1>
</div>
<!--<div class="col-lg-3"></div>-->
<div class="col-lg-6" style="font-size: 12pt;">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $model->surname.' '.$model->name; ?></h3>           
        </div>
        <div class="panel-body">
            <small style="float: right;"><em>Дата регистрации: <?php echo $model->date; ?></em></small>
            <div class="col-lg-6" style="margin-top: 20px;">
                <i class="fa fa-user"></i> Имя:
            </div>
            <div class="col-lg-6" style="margin-top: 20px;">
                <?php echo $model->name; ?>
            </div>  
            
            <div class="col-lg-6" style="margin-top: 10px;">
                <i class="fa fa-user"></i> Фамилия:
            </div>
            <div class="col-lg-6" style="margin-top: 10px;">
                <?php echo $model->surname; ?>
            </div>
            
            <div class="col-lg-6" style="margin-top: 10px;">
                <i class="fa fa-envelope"></i> E-mail:
            </div>
            <div class="col-lg-6" style="margin-top: 10px;">
                <?php echo $model->mail; ?>
            </div>
            
            <div class="col-lg-6" style="margin-top: 10px;">
                <i class="fa fa-phone"></i> Телефон:
            </div>
            <div class="col-lg-6" style="margin-top: 10px;">
                <?php echo $model->phone; ?>
            </div>

            <div class="col-lg-6" style="margin-top: 10px;">
                <i class="fa fa-credit-card"></i> Карта:
            </div>
            <div class="col-lg-6" style="margin-top: 10px;">
                <?php echo $model->card; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>