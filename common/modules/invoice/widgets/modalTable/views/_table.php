<?php
/* @var $this \yii\web\View */

/* @var $invoice_id integer */
/* @var $text string */


use common\modules\invoice\widgets\modalTable\assets\InvoiceModalAsset;
use yii\helpers\Html;


InvoiceModalAsset::register($this);
?>
<?= Html::button($text,
    [
        'class' => "btn btn-primary btn-xs modal-open",
        //  'data-toggle'=>"modal",
        //    'data-target'=>"#invoice-modal",
        'invoice-id' => $invoice_id,
    ]) ?>