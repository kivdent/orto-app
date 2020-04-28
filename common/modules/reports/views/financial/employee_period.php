<?php

use common\modules\employee\models\Employee;
use common\modules\reports\models\DailyReport;
use common\modules\reports\models\PeriodReport;
use common\modules\reports\widgets\financialPeriodChooseWidget\FinancialPeriodChooseWidget;
use common\modules\schedule\models\TimeSheet;
use common\modules\userInterface\models\UserInterface;
use common\widgets\tableWidget\TableWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $period_report PeriodReport */
/* @var $daily_report DailyReport */
/* @var $employee_selectable boolean */
$this->title = 'Отчёт за период ' . $period_report->startDate . '-' . $period_report->endDate;
$this->title .= $period_report->defined ? '' : '<span class="label label-warning">Период не установлен</span>';
$this->registerJs("
$('#employee_id').change(function() {
let href=\"/reports/financial/employee-period?period_id=" . Yii::$app->request->get('period_id') . "\";
href+= \"&employee_id=\"+$('#employee_id').val();
href+=\"&employee_selectable=1\";
window.location=href;
})");

?>
<?= FinancialPeriodChooseWidget::widget([
    'link' => "/reports/financial/employee-period",
    'var' => 'period_id',
    'period_month' => date("n", strtotime($period_report->financial_period->nach)),
    'period_year' => date("Y", strtotime($period_report->financial_period->nach)),
]) ?>
<br>
<?php if ($employee_selectable == 1): ?>
    <?= Html::dropDownList('employee_id', $period_report->employee->id, Employee::getNursesList(),
        ['id' => 'employee_id',]); ?>
<?php endif; ?>
<h3><?= $this->title ?></h3>
<h4>Выписано чеков: <?= $period_report->invoice_summary ?> р.</h4>
<h4>Сумма для зарплаты: <?= $period_report->coefficient_summary ?>р.</h4>
<h4>Отработано часов: <?= UserInterface::SecondsToHours(TimeSheet::getPeriodDuration($period_report->financial_period,$period_report->employee))?></h4>

<?php foreach ($period_report->daily_reports as $daily_report): ?>
    <?php if (count($daily_report->table)): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-4">
                        Дата: <?= Yii::$app->formatter->asDate($daily_report->date, 'php:d.m.Y') ?></div>
                    <div class="col-lg-4">Выписано чеков: <?= $daily_report->invoice_summary ?></div>
                    <div class="col-lg-4">Сумма балов: <?= $daily_report->coefficient_summary ?></div>
                </div>
            </div>
            <?= TableWidget::widget([
                'table' => $daily_report->table,
                'labels' => $daily_report->labels
            ]) ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

