<?php
/* @var  $this \yii\web\View */

use common\modules\invoice\widgets\form\InvoiceFormWidget;
use common\modules\clinic\models\FinancialDivisions;

/* @var $invoice \common\modules\invoice\models\Invoice */
?>

<div class="small">
    <p class="text-center">
        Акт выполненных работ №<?=$invoice->id ?> от <?= Yii::$app->formatter->asDate($invoice->lastPaymentDate, 'php:d.m.Y') ?>
    </p>
    <div class="row">
        <div class="col-xs-12">
            Исполнитель: <?= $invoice->lastPayment->financialDivision->requisitesString ?>, адрес: <?= $invoice->lastPayment->financialDivision->addressString ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            Заказчик: <?= $invoice->patientFullName ?>, адрес: <?= $invoice->patient->addressString ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= InvoiceFormWidget::getInvoiceTable($invoice->id) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            Вышеперечисленные услуги выполнены полностью и в срок. Заказчик претензий по объему, качеству и срокам оказания услуг не имеет.
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">Заказчик ________<?= $invoice->getPatientFullName() ?></div>
        <div class="col-xs-6">Исполнитель ________<?= Yii::$app->user->identity->employe->fullName ?></div>
    </div>
</div>