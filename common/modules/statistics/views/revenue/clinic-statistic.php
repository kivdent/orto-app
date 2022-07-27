<?php



/* @var $this \yii\web\View */
/* @var $clinicStatistic \common\modules\statistics\models\ClinicStatistic */
/* @var $type string\common\modules\statistics\models\ClinicStatistic */

use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;
use common\modules\reports\widgets\financialPeriodChooseWidget\FinancialPeriodChooseWidget;
use yii\helpers\Html;

$this->title=$clinicStatistic->titles[$type];

$this->params['breadcrumbs'][] = ['label'=>'Выручка','url'=>['revenue/index','financialPeriodId'=>Yii::$app->request->get('financialPeriodId')]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= FinancialPeriodChooseWidget::widget(['link' => '/statistics/revenue/material','var' => 'financialPeriodId',])?><br>

<?=$this->title.": ".call_user_func([$clinicStatistic,$type.'Summary']);?>


<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#positions" aria-controls="positions" role="tab" data-toggle="tab">Позиции</a></li>
    <li role="presentation"><a href="#allDoctors" aria-controls="allDoctors" role="tab" data-toggle="tab">Таблица по врачам</a></li>
    <li role="presentation"><a href="#invoices" aria-controls="invoices" role="tab" data-toggle="tab">Все счета</a></li>
</ul>

<!-- Tab panes -->

<!-- Positions -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="positions">
        <table class="table table-bordered">
            <?php foreach (call_user_func([$clinicStatistic,$type.'PriceListItems']) as $position):?>
                <tr>
                    <td><?=$position['title']?></td>
                    <td><?=$position['total']?></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>

    <!-- Doctors -->
    <div role="tabpanel" class="tab-pane" id="allDoctors">
<table class="table table-bordered">
    <tr><th>Врач</th><th>Сумма по счетам</th><th>Оплат за период</th><th>Долги за 3 месяца</th></tr>
    <?php foreach (call_user_func([$clinicStatistic,$type.'PaymentsForTable']) as $payment):?>

        <tr>
            <td><?=\common\modules\employee\models\Employee::findOne($payment['doctor_id'])->fullName?></td>
            <td>Сумма по счетам</td>
            <td><?=$payment['summ']?></td>
            <td>Долги за 3 месяца</td>
        </tr>
    <?php endforeach;?>
</table>

    </div>

    <!-- Invoices -->
    <div role="tabpanel" class="tab-pane" id="invoices">
            <?php foreach (call_user_func([$clinicStatistic,$type.'Payments']) as $payment):?>
                <?= InvoiceModalWidget::widget(['invoice_id' => $payment->dnev])?>
                <?= $payment->date." ".$payment->invoice->employeeFullName." ".$payment->vnes?><br>
            <?php endforeach;?>

    </div>
</div>

</div>

