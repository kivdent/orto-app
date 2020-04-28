<?php
/* @var $this \yii\web\View */

/* @var $payment \common\modules\cash\models\Payment */

use common\modules\clinic\models\FinancialDivisions;
use common\modules\invoice\widgets\form\InvoiceFormWidget; ?>
<div class="small">
<p class="text-center">
    Оплата №<?= $payment->id ?> от
    <?= Yii::$app->formatter->asDate($payment->date, 'php:d.m.Y') ?>
</p>
<div class="row">
    <div class="col-xs-6">
        Врач: <?= $payment->invoice->getEmployeeFullName() ?> <br>
        Пациент: <?= $payment->invoice->getPatientFullName() ?><br>
        Вид оплаты: <?= $payment->typeName ?><br>
        Внесено: <?= $payment->vnes ?> р.<br>
    </div>
    <div class="col-xs-6">
        <?= FinancialDivisions::findOne($payment->podr)->name ?><br>
        ИНН: <?= FinancialDivisions::findOne($payment->podr)->requisites->INN ?>

    </div>
</div>
<p class="text-center">
    Счёт №<?= $payment->invoice->id ?> от
    <?= $payment->invoice->date ?>
</p>
<?= InvoiceFormWidget::getInvoiceTable($payment->invoice->id) ?>
<div class="row">
    <div class="col-xs-6">Пациент ________<?= $payment->invoice->getPatientFullName() ?></div>
    <div class="col-xs-6">Врач ________<?= $payment->invoice->getEmployeeFullName() ?></div>
</div>
</div>