<?php

use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;
use common\modules\statistics\models\ClinicStatistic;
use common\modules\statistics\models\DoctorStatistics ;
use common\modules\statistics\models\HygieneProducts;
use common\modules\statistics\models\Material;
use common\modules\statistics\models\XRayCount;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var  $hygieneProductsStatistics HygieneProducts[] */
/* @var  $material Material[] */
/* @var  $clinicStatistic ClinicStatistic[] */
/* @var  $xRayStatistic XRayCount[] */
/* @var  $doctorStatistics  DoctorStatistics */
/* @var  $periods [] */
?>

<?= \common\modules\reports\widgets\financialPeriodChooseWidget\FinancialPeriodChooseWidget::widget(['link' => '/statistics/revenue', 'var' => 'financialPeriodId',]) ?>
<br>

<a href="/statistics/revenue/xls-save" class="/btn btn-primary" target="_blank">Сохранить таблицу</a>
<table class="table table-bordered">
    <tr>
        <th>Напрвление</th>
        <?php foreach ($periods as $period): ?>
            <th>
                <?= $period['title'] ?>
            </th>
        <?php endforeach; ?>
    </tr>

    <tr>
        <td>Сумма выручки врачей по клинике</td>
        <?php foreach ($periods as $period): ?>
            <td>
                <?=
                Html::a($clinicStatistic[$period['id']]->doctorsSummary-$xRayStatistic[$period['id']]->summary,
                    ['revenue/clinic-statistic', 'financialPeriodId' => Yii::$app->request->get('financialPeriodId'), 'type' => 'getDoctors'],
                    ['class' => 'btn btn-success btn-xs']) ?>
            </td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Сумма выручки рентген</td>
        <?php foreach ($periods as $period): ?>
            <td>
                <?=
                Html::a($xRayStatistic[$period['id']]->summary,
                    ['revenue/clinic-statistic', 'financialPeriodId' => Yii::$app->request->get('financialPeriodId'), 'type' => 'getXRay'],
                    ['class' => 'btn btn-success btn-xs']) ?>
            </td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Сумма за период по материалам</td>
        <?php foreach ($periods as $period): ?>
            <td>
                <?= Html::a($clinicStatistic[$period['id']]->materialSummary - $hygieneProductsStatistics[$period['id']]->summary,
                    ['revenue/clinic-statistic', 'financialPeriodId' => Yii::$app->request->get('financialPeriodId'), 'type' => 'getMaterial'],
                    ['class' => 'btn btn-success btn-xs']) ?>
            </td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Сумма за период по средствам гигиены</td>
        <?php foreach ($periods as $period): ?>
            <td>
                <?= Html::a($hygieneProductsStatistics[$period['id']]->summary,
                    ['revenue/hygiene-product', 'financialPeriodId' => Yii::$app->request->get('financialPeriodId')],
                    ['class' => 'btn btn-success btn-xs']) ?>
            </td>
        <?php endforeach; ?>
    </tr>

</table>
<table class="table table-bordered table-condensed">
    <?php foreach ($doctorStatistics->financial as $doctorStatistic): ?>
        <!--    Заголовки таблицы-->

        <tr>
            <th rowspan="2">Врач</th>
            <?php foreach ($doctorStatistics->periods as $period): ?>
                <th colspan="4"><?= $period['title'] ?></th>
            <?php endforeach; ?>

        </tr>
        <tr>

            <?php foreach ($doctorStatistics->periods as $period): ?>
                <th>Выручка</th>
                <th>Часы</th>
                <th>Секунды</th>
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
                    <td><?= $employeeStat[$period['id']]['seconds'] ?></td>
                    <td><?= $employeeStat[$period['id']]['revenue_per_hour'] ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>