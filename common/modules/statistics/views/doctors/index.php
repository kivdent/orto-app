<?php
/* @var $this yii\web\View */

/* @var $doctorStatistics DoctorStatistics */

use common\modules\reports\widgets\financialPeriodChooseWidget\FinancialPeriodChooseWidget;
use common\modules\statistics\models\DoctorStatistics;

?>
<?= FinancialPeriodChooseWidget::widget(['link' => '/statistics/doctors', 'var' => 'financialPeriodId',]) ?><br>
<table class="table table-bordered table-condensed">
    <?php foreach ($doctorStatistics->financial as $doctorStatistic): ?>
        <!--    Заголовки таблицы-->

        <tr>
            <th rowspan="2">Врач</th>
            <?php foreach ($doctorStatistics->periods as $period): ?>
                <th colspan="3"><?= $period['title'] ?></th>
            <?php endforeach; ?>

        </tr>
        <tr>

            <?php foreach ($doctorStatistics->periods as $period): ?>
                <th>Выручка</th>
                <th>Часы</th>
                <th>В час</th>
            <?php endforeach; ?>
        </tr>
        <!--    Тело таблицы-->
        <?php foreach ($doctorStatistic as $employee_id => $employeeStat): ?>
            <tr>
                <td><?= $employeeStat['fullName'] ?></td>
                <?php foreach ($doctorStatistics->periods as $period): ?>
                    <td><?= $employeeStat[$period['id']]['revenue'] ?></td>
                    <td><?= $employeeStat[$period['id']]['hour'] ?></td>
                    <td><?= $employeeStat[$period['id']]['revenue_per_hour'] ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>