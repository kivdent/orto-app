<?php

use common\modules\salary\models\SalaryCardType;
use common\modules\salary\models\SalaryReport;
use common\modules\userInterface\models\UserInterface;
use common\widgets\tableWidget\TableWidget;

/* @var $this yii\web\View */
/* @var $table */
$this->title = 'Расчёт зарплаты за период ';
?>

    <?= TableWidget::widget([
        'table' =>$table['table'],
        'labels' => $table['labels'],
    ]) ?>



