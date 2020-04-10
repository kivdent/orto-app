<?php
/* @var $this \yii\web\View*/
/* @var $invoice_id integer*/
use common\modules\invoice\widgets\modalTable\assets\InvoiceModalAsset;
use yii\helpers\Html;
InvoiceModalAsset::register($this);
?>
<?=Html::button('<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>',[
    'class'=>"btn btn-primary btn-xs modal-open",
    //  'data-toggle'=>"modal",
    //    'data-target'=>"#invoice-modal",
    'invoice-id'=>$invoice_id,

])?>
