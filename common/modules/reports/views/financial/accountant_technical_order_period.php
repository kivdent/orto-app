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
/* @var $period_reports PeriodReport[] */
/* @var $daily_report DailyReport */
/* @var $employee_selectable boolean */
\common\modules\invoice\assets\InvoiceAsset::register($this);
$this->title = 'Отчёт по лаборатории ' . $period_reports[0]->startDate . '-' . $period_reports[0]->endDate;
$this->title .= $period_reports[0]->defined ? '' : '<span class="label label-warning">Период не установлен</span>';
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
    'period_month' => date("n", strtotime($period_reports[0]->financial_period->nach)),
    'period_year' => date("Y", strtotime($period_reports[0]->financial_period->nach)),
]) ?>

<br>

<h3><?= $this->title ?></h3>
<?php foreach ($period_reports as $period_report): ?>
    <h4>Техник: <?= $period_report->employee->fullName ?></h4>
    <h4>Сумма закрытых нарядов: <?= $period_report->coefficient_summary ?>р.</h4>
    <?php if (count($period_report->daily_reports)): ?>
        <?= TableWidget::widget([
            'table' => $period_report->getManipulationPrintTable()['table'],
            'labels' => $period_report->getManipulationPrintTable()['labels']
        ]) ?>
    <?php endif; ?>
<?php endforeach; ?>
