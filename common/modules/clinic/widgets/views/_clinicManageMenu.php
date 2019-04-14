<?php
/*@var $menuItems array*/
/* @var $this yii\web\View */
use yii\bootstrap\Nav;
use Yii;
?>

<?=Nav::widget([
     'options' => ['class' => 'nav nav-tabs'],
        'items'=>$menuItems,
        ]);?>

