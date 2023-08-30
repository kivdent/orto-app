<?php
/* @var $this \yii\web\View */

/* @var $payment \common\modules\cash\models\Payment */

use common\modules\clinic\models\FinancialDivisions;
use common\modules\invoice\widgets\form\InvoiceFormWidget; ?>
<div class="small">
    <p class="text-center">
        Акт выполненных работ №<?= $payment->invoice ?> от
        <?= Yii::$app->formatter->asDate($payment->date, 'php:d.m.Y') ?>
    </p>
    <div class="row">
        <div class="col-xs-12">
            Исполнитель: <?= FinancialDivisions::findOne($payment->podr)->name ?> ИНН: <?= FinancialDivisions::findOne($payment->podr)->requisites->INN ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            Закзчик: <?=$payment->invoice->getPatientFullName()?>
        </div>
    </div>

    <?= InvoiceFormWidget::getInvoiceTable($payment->invoice->id) ?>
    <div class="row">
        <div class="col-xs-6">Заказчик ________<?= $payment->invoice->getPatientFullName() ?></div>
        <div class="col-xs-6">Исполнитель ________<?= Yii::$app->user->identity->employee->fullName ?></div>
    </div>
</div>