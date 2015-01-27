<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script> 
    <?php $this->pageTitle = 'Пользователи'; ?>  
</head>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'users',
    'enableAjaxValidation' => false,
        ));
?>
<div class="page-header">
    <h1 style="display: inline;">Пользователи</h1>
</div>
<?php
if (isset($users))
    foreach ($users as $user)
    {
        echo '<a class="list-group-item" href="/?r=backend/UserAdmin&id='.$user->id.'">';
        echo $user->surname.'  '.$user->name
        .'<span class="badge">'.$user->phone.'</span>';
        echo '</a>';
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
<?php $this->endWidget(); ?>