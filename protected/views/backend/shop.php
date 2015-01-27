<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <?php $this->pageTitle = 'Магазин'; ?>  
</head>


<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'shop',
    'enableAjaxValidation' => false,
        ));
?>

<div class="page-header">
    <h1 style="display: inline;">Настройка магазина</h1> 
    <?php echo CHtml::link('Добавить товар', array('backend/AddProduct'), array('class' => 'btn btn-success', 'style' => 'float:right;')); ?>
    <?php echo CHtml::link('Редактировать заголовок', array('backend/ShopTitleEdit'), array('class' => 'btn btn-info', 'style' => 'float:right; margin-right:10px;')); ?>
</div>

<div class="col-lg-4" style="padding-left: 0px;">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Категории</h3>
        </div>
        <div class="panel-body">
            <?php
            if (isset($categories))
                foreach ($categories as $cat)
                {
                    echo CHtml::link($cat->name, array('backend/shop', 'id' => $cat->id), array('style' => 'font-size: 14pt;')).'<br>';
                }
            ?>
            <div class="text-right" style="margin-top: 30px;">
                <?php echo CHtml::link('Добавить категорию <i class="fa fa-arrow-circle-right"></i>', array('backend/AddCategory'), array('style' => '')); ?>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-8">
    <div class="panel panel-default" style="padding-right: 0px;">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> 
                <?php
                if ($load == true)
                {
                    echo $category->name;
                    echo CHtml::link('Удалить категорию', array('backend/DeleteCategory', 'id' => $category->id), array('class' => 'btn btn-xs btn-danger', 'style' => 'float:right; color: white;', 'confirm' => 'Хотите удалить категорию? (весь товар из нее удалится)'));
                    echo CHtml::link('Изменить категорию', array('backend/EditCategory', 'id' => $category->id), array('class' => 'btn btn-xs btn-warning', 'style' => 'float:right; margin-right: 10px; color: white;'));
                } else
                    echo 'Товары';
                ?>
            </h3>

        </div> 

        <div class="panel-body">
            <?php
            if ($load == true)
            {
                foreach ($products as $product)
                {
                    echo '<a class="list-group-item" href="/?r=backend/EditProduct&id='.$product->id.'">';
                    echo $product->title.'<span class="badge">'.$product->in_stock.'</span>';
                    echo '</a>';
                }
            } else
            {
                foreach ($products as $product)
                {
                    echo '<a class="list-group-item" href="/?r=backend/EditProduct&id='.$product->id.'">';
                    echo $product->title.'<span class="badge">'.$product->in_stock.'</span>';
                    echo '</a>';
                }
            }
            ?>

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
                <style>
                    ul.pagination .first, ul.pagination .last {
                        display: none;
                    }
                </style>   
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
