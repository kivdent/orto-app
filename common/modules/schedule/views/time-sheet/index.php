<?php

use common\modules\schedule\models\TimeSheetManager;
use common\modules\userInterface\models\UserInterface;
use common\widgets\tableWidget\TableWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $timeSheetManager TimeSheetManager */

$this->title = 'Табель ';
?>
<div class="row">
    <div class="col-lg-12">
        <h3>
            <?=$this->title?>
            <?= Html::a(
                UserInterface::getMonthName(date('n', strtotime(date('d.m.Y', $timeSheetManager->startDate) . '-1 month'))),
                ['index', 'start_date' => date('01.m.Y', strtotime(date('d.m.Y', $timeSheetManager->startDate) . '-1 month'))]
            ) ?>|<?= strtolower(UserInterface::getMonthName(date('n', $timeSheetManager->startDate))) ?>|
            <?= Html::a(
                UserInterface::getMonthName(date('n', strtotime(date('d.m.Y', $timeSheetManager->startDate) . '+1 month'))),
                ['index', 'start_date' => date('01.m.Y', strtotime(date('d.m.Y', $timeSheetManager->startDate) . '+1 month'))]
            ) ?></h3>

    </div>
</div>
<div class="time-sheet-index">


    <?= TableWidget::widget([
        'labels' => $timeSheetManager->days,
        'table' => $timeSheetManager->table,
    ]) ?>

</div>
