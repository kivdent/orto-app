<?php
/* @var $this \yii\web\View */

/* @var $payment \common\modules\cash\models\Payment */

use common\modules\clinic\models\FinancialDivisions;
use common\modules\invoice\widgets\form\InvoiceFormWidget;
use yii\helpers\Html;

$this->title = 'Оплата' ?>
<div class="row">
    <?= Html::a('Печать', ['/cash/payment/print', 'payment_id' => $payment->id], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
    <?= Html::a('Акт выполненных работ', ['/invoice/manage/print-akt', 'invoice_id' => $payment->invoice->id], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>

</div>
<div>
    <p class="text-center">
        Оплата №<?= $payment->id ?> от
        <?= Yii::$app->formatter->asDate($payment->date, 'php:d.m.Y') ?>
    </p>
    <div class="row">
        <div class="col-xs-6">
            Счёт №<?= $payment->invoice->id ?> от <?= $payment->invoice->date ?><br>
            Врач: <?= $payment->invoice->getEmployeeFullName() ?> <br>
            Пациент: <?= $payment->invoice->getPatientFullName() ?><br>
            Вид оплаты: <?= $payment->typeName ?><br>
            Внесено: <?= $payment->vnes ?> р.<br>
        </div>

    </div>
    <p class="text-center">


    </p>
    <?= InvoiceFormWidget::getInvoiceTable($payment->invoice->id) ?>
</div>