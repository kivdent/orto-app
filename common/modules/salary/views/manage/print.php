<?php


use common\modules\salary\models\SalaryReport;
use common\modules\userInterface\models\UserInterface;


/* @var $this yii\web\View */
/* @var $salaryReports array|SalaryReport */
/* @var $salaryReport SalaryReport */
$this->title = 'Расчёт зарплаты за период ' . UserInterface::getFormatedDate($salaryReports[0]->financial_period->nach) . "-" . UserInterface::getFormatedDate($salaryReports[0]->financial_period->okonch);
?>

<h2><?= $this->title ?></h2>
<div class="small"><?= $this->render('_report_form', [
        'salaryReports' => $salaryReports
    ]) ?></div>

