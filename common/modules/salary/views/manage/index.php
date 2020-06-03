<?php


use common\modules\reports\widgets\financialPeriodChooseWidget\FinancialPeriodChooseWidget;
use common\modules\salary\models\SalaryReport;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $salaryReports array|SalaryReport */
/* @var $salaryReport SalaryReport */
$this->title = 'Расчёт зарплаты за период ' . UserInterface::getFormatedDate($salaryReports[0]->financial_period->nach) . "-" . UserInterface::getFormatedDate($salaryReports[0]->financial_period->okonch);
if (!$salaryReports[0]->financial_period->defined) {
    $this->title .= '<span class="label label-warning">Период не установлен</span>';
}
?>

<?= FinancialPeriodChooseWidget::widget([
    'link' => '/salary/manage/index',
    'var' => 'financial_period_id',
    'period_month' => date("n", strtotime($salaryReports[0]->financial_period->nach)),
    'period_year' => date("Y", strtotime($salaryReports[0]->financial_period->nach)),
])
?>

<h2><?= $this->title ?>
    <?= Html::a(
        'Печать',
        ['/salary/manage/print', 'financial_period_id' => $salaryReports[0]->financial_period->id],
        ['class' => 'btn btn-success']) ?>
</h2>

<?= $this->render('_report_form', [
    'salaryReports' => $salaryReports
]) ?>

