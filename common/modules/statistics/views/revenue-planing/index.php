<?php

/* @var $this \yii\web\View */
/* @var $revenuePlannings \common\modules\statistics\models\RevenuePlaning[] */
/* @var $dailyRevenue \common\modules\statistics\models\DailyRevenue */

use common\modules\userInterface\models\UserInterface;

$this->title = 'Планирование выручки';
//\common\modules\userInterface\models\UserInterface::getVar($revenuePlannings)
?>

    <h1><?= $this->title ?></h1>
<?= \common\modules\reports\widgets\financialPeriodChooseWidget\FinancialPeriodChooseWidget::widget(['link' => '/statistics/revenue', 'var' => 'financialPeriodId',]) ?>
    <br>
<?php foreach ($revenuePlannings->dailyRevenue as $clinic => $dailyRevenue): ?>

    <table class="table table-bordered table-condensed">

        <tr>
            <td>Доктор</td>
            <?php  for ($date = strtotime($revenuePlannings->startDate); $date < strtotime($revenuePlannings->endDate); $date = strtotime(date('d.m.Y', $date) . ' +1 day')): ?>
                <td><?= date('d.m.Y',$date)?></td>
            <?php endfor; ?>
        </tr>
        <?php foreach (array_keys($dailyRevenue) as $doctor_id): ?>
            <tr>
                <td><?= $dailyRevenue[$doctor_id][$revenuePlannings->startDate]->doctorFullName ?></td>
                <?php  for ($date = strtotime($revenuePlannings->startDate); $date < strtotime($revenuePlannings->endDate); $date = strtotime(date('d.m.Y', $date) . ' +1 day')): ?>
                    <td><?= isset($dailyRevenue[$doctor_id][date('d.m.Y',$date)])?$dailyRevenue[$doctor_id][date('d.m.Y',$date)]->revenuePlan:'Нет' ?></td>
                <?php endfor; ?>
            </tr>
        <?php endforeach; ?>

    </table>
<?php endforeach; ?>