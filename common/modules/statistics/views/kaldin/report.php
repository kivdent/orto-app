<?php

/* @var $this yii\web\View */

/* @var $reports KaldinReport[] */
/* @var $startDate string*/
/* @var $period int */

use common\modules\statistics\models\KaldinReport;

$this->title = 'Отчёт по кальдину';
?>
<h1><?= $this->title ?></h1>
<div class="row">
    <div class="col-lg-12">
        <?= \common\modules\schedule\widgets\TimeAppointmentChooser::widget([
            'start_date' => $startDate,
//        'patient_id' => $patient_id,
//        'doctor_id' => $doctor_id,
            'base_link' => '/statistics/kaldin/report',
            'duration' => $period,
        ]) ?>
    </div>
</div>
<table class="table table-bordered">
    <tr>
        <th>№</th>
        <th>ФИО врача</th>
        <th>Специализация</th>
        <th>Рабочих часов (врач в кабинете)</th>
        <th>Рабочих часов (c пациентом)</th>
        <th>Стоимость оказанных услуг(руб)</th>
        <th>Кол-во посещений</th>
        <th>Кол-во пациентов</th>
        <th>Кол-во первичных</th>
        <th>Стоимость посещения</th>
        <th>Выручка на физическое лицо</th>
        <th>Посещений 1-м физическим лицом</th>
        <th>Объём помощи</th>
        <th>% первичных к посещениям</th>
        <th>Оценка загрузки по посещениям</th>
        <th>Оценка загрузки по времени</th>
        <th>Состояние врача</th>
    </tr>
    <?php $i = 1; ?>
    <?php foreach ($reports as $report): ?>

        <tr>
            <td><?=$i?></td>
            <td><?=\yii\helpers\Html::a($report->doctor->fullName,[
                    'kaldin/doctor-report',
                        'start_date'=>$startDate,
                        'doctor_id'=>$report->doctor->id,
                        'period'=>$period
                    ],['target'=>'_blank'])?></td>
            <td><?=$report->doctor->positionName?></td>
            <td><?=$report->workingHours?></td>
            <td><?=$report->workingHoursWithPatients?></td>
            <td><?=$report->invoicesSummary?></td>
            <td><?=$report->appointmentsCount?></td>
            <td><?=$report->patientsCount?></td>
            <td><?=$report->firstAppointmentCount?></td>
            <td><?=$report->visitCost?></td>
            <td><?=$report->revenuePerIndividual?></td>
            <td><?=$report->visitsByIndividual?></td>
            <td><?=$report->volume?></td>
            <td><?=$report->firstToAll?></td>
            <td><?=$report->loadByVisit?></td>
            <td><?=$report->loadByTime?></td>
            <td><?=$report->loadStatus?></td>
        </tr>
        <?php $i++; ?>
    <?php endforeach; ?>

</table>