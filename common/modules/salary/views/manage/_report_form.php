<?php

use common\modules\salary\models\SalaryCardType;
use common\modules\salary\models\SalaryReport;
use common\modules\userInterface\models\UserInterface;
use common\widgets\tableWidget\TableWidget;

/* @var $this yii\web\View */
/* @var $salaryReports array|SalaryReport */
/* @var $salaryReport SalaryReport */$this->title = 'Расчёт зарплаты за период ' . UserInterface::getFormatedDate($salaryReports[0]->financial_period->nach) . "-" . UserInterface::getFormatedDate($salaryReports[0]->financial_period->okonch);
?>


<?php foreach ($salaryReports as $salaryReport): ?>
    <h4><?= SalaryCardType::getTypeList()[$salaryReport->type] ?></h4>
        <?= TableWidget::widget([
            'table' => $salaryReport->table,
            'labels' => $salaryReport->labels,
        ]) ?>

<?php endforeach; ?>

