<?php

use common\modules\clinic\models\FinancialDivisions;
use common\modules\employee\models\Employee;
use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;
use common\modules\patient\models\Patient;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $cashbox \common\modules\cash\models\Cashbox */
/* @var $financial_report \common\modules\reports\models\FinancialReports */
/* @var $divisions array*/
/* @var $print boolean*/

?>
<h4><?= $this->title ?></h4>
<div id="total-cash">
    <h5>Общий остаток в кассе: <?= $cashbox->summ ?> р.</h5>
</div>
<div id="division-cash">
    <table class="table table-striped">
        <thead>
        <th>Подразделение</th>
        <?php foreach ($cashbox->getPaymentTypes() as $paymentType_id => $paymentType_title): ?>
            <th><?= $paymentType_title ?></th>
        <?php endforeach; ?>
        <th>Выдано из кассы</th>
        </thead>
        <tbody>
        <?php foreach ($divisions as $division_id => $division_title): ?>
            <tr>
                <td>
                    <?= $division_title ?>
                </td>
                <?php foreach ($cashbox->getPaymentTypes() as $paymentType_id => $paymentType_title): ?>
                    <td><?= $financial_report->getSummaryPerPaymentType($paymentType_id, $division_id) ?></td>
                <?php endforeach; ?>
                <td>
                    <?=$financial_report->getAccountCashSumm($cashbox,$division_id)?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div id="account_cash_warrant"><h4>Выдача наличных из кассы</h4>
    <?php foreach ($divisions as $division_id => $division_title): ?>
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading"><?= $division_title . " " . $financial_report->getAccountCashSumm($cashbox, $division_id) . "р." ?></div>
            <?php if ($financial_report->getAccountCash($cashbox, $division_id)): ?>
                <table class="table table-bordered table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>Сотрудник</th>
                        <th>Сумма</th>
                        <th>Цель</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($financial_report->getAccountCash($cashbox, $division_id) as $accountCash): ?>
                        <tr>
                            <td><?= $accountCash->employee->fullName ?></td>
                            <td><?= $accountCash->summ ?></td>
                            <td><?= $accountCash->typeName ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<div id="division-report"><h4>Отчёт по оплатам</h4>
    <?php foreach ($divisions as $division_id => $division_title): ?>
        <div id="division-<?= $division_id ?>"><h5><?= $division_title ?></h5>
            <?php foreach ($financial_report->getEmployeeWithInvoices($division_id) as $employee_id => $payments): ?>
                <?php $summ = 0; ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong><?= Employee::findOne($employee_id)->getFullName() ?></strong> Сумма: <?=$financial_report->getSummEmployeeWithInvoices($employee_id,$division_id)?></div>
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>Пациент</th>
                            <th>Сумма</th>
                            <th>Вид оплаты</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($payments as $payment):?>
                            <tr>
                                <td>
                                    <?=$payment->invoice->patient->fullName?><?=
                                    ($print)?'':Html::a(
                                        '<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>',
                                        ['/patient/manage/view', 'patient_id' => $payment->invoice->patient_id],
                                        ['class' => 'btn btn-xs btn-primary']
                                    ) ?></td>
                                <td><?= $payment->vnes?> р.
                                    <?=($print)?'':InvoiceModalWidget::widget(['invoice_id' => $payment->dnev]) ?>
                                    <?=($print)?'':Html::a('<span class="glyphicon glyphicon-print"></span>',['/cash/payment/print','payment_id'=>$payment->id],['class'=>'btn btn-xs btn-primary','target'=>'_blank']) ?>
                                </td>
                                <td><?= $payment->typeName ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>

                    </table>

                </div>

            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
