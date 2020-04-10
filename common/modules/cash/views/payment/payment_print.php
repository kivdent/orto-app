<?php
/* @var $this \yii\web\View*/
/* @var $payment \common\modules\cash\models\Payment*/

use common\modules\invoice\widgets\form\InvoiceFormWidget; ?>
<div class="row">
    <div class="col-xs-6">
        Врач: <?= $payment->invoice->getEmployeeFullName() ?> <br>
        Пациент: <?= $payment->invoice->getPatientFullName()?><br>
        Вид оплаты: <?= $payment->typeName?><br>
        Дата оплаты: <?= Yii::$app->formatter->asDate($payment->date,'php:m.d.Y')?><br>
    </div>
    <div class="col-xs-6">
<?=\common\modules\clinic\models\FinancialDivisions::getDivisionList()[$payment->podr]?>
    </div>
</div>
<p class="text-center">
    Счёт №<?=$payment->invoice->id?> от 
    <?=$payment->invoice->date?>
</p>
<?= InvoiceFormWidget::getInvoiceTable($payment->invoice->id)?>
<div class="row">
    <div class="col-xs-6">Пациент ________<?= $payment->invoice->getPatientFullName()?></div>
    <div class="col-xs-6">Врач ________<?= $payment->invoice->getEmployeeFullName() ?></div>
</div>
