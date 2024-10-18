<?php

/* @var $this yii\web\View */
/* @var $report KaldinReport */
/* @var $startDate string */
/* @var $period int */

/* @var $doctor_id int */

use common\modules\statistics\models\KaldinReport;
use yii\helpers\Html;

$this->title = 'Отчёт по кальдину для врача '.$report->doctor->fullName;
?>
<h1><?=$this->title?></h1>
<table class="table table-bordered" id="table_appointment">
    <tr>
        <td>Пациент</td>
        <td>Дата назначения</td>
        <td>Время назначения</td>
        <td>Продолжительность приёма</td>
        <td>Содержание назначения</td>
        <td>Первичный</td>
    </tr>
    <?php foreach ($report->appointments as $appointment): ?>
        <tr>
            <td><?= Html::a($appointment->patient->fullName, ['/patient/manage/update', 'patient_id' => $appointment->patient->id], ['target' => '_blanc']) ?></td>
            <td><?= $appointment->appointments_day->date ?></td>
            <td><?= $appointment->NachNaz ?>-<?= $appointment->OkonchNaz ?></td>
            <td><?= $appointment->appointment_content ?></td>
            <td><?= round($appointment->durationSeconds/60, 2) ?> мин</td>
            <td><?= $appointment->initialDateFlag ? 'Первичный' : 'Повторный' ?></td>
        </tr>

    <?php endforeach; ?>
</table>
<h2>Манипуляции</h2>
<table class="table table-bordered" id="table_appointment">
    <tr>
        <td>Манипуляция</td>
        <td>Количество</td>
    </tr>
    <?php foreach ($report->pricelistItems as $pricelistItem): ?>
            <td><?= $pricelistItem['title'] ?></td>
            <td><?= $pricelistItem['count'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>