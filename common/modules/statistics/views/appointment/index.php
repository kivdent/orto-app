<?php
/* @var $this yii\web\View */

/* @var  $appointmentStatistics AppointmentStatistics[] */
/* @var  $start_date string */

/* @var  $duration integer */

use common\modules\statistics\models\AppointmentStatistics;
use yii\helpers\Html;

$this->title = "Статистика записей";
?>
    <h1><?= $this->title ?></h1>
    <div class="col-lg-4">
        <?= \common\modules\schedule\widgets\TimeAppointmentChooser::widget([
            'start_date' => $start_date,
//        'patient_id' => $patient_id,
//        'doctor_id' => $doctor_id,
            'base_link' => '/statistics/appointment/index',
            'duration' => $duration,
        ]) ?>
    </div><br/>
<?php foreach ($appointmentStatistics as $appointmentStatistic): ?>
    Дата: <?= $appointmentStatistic->date->format('d.m.Y') ?>
    <button class="btn btn-primary" type="button" data-toggle="collapse"
            data-target="#table_appointment_<?= $appointmentStatistic->date->format('d-m-Y') ?>"
            aria-expanded="false" aria-controls="table_appointment_<?= $appointmentStatistic->date->format('d-m-Y') ?>">
        Назначения
    </button>
<table class="table">
    <tr><td>Назначений за день</td><td><?=$appointmentStatistic->countAppointment?></td></tr>
    <tr><td>Первичных за день</td><td><?=$appointmentStatistic->initialAppointment?></td></tr>
</table>
    <table class="table collapse" id="table_appointment_<?= $appointmentStatistic->date->format('d-m-Y') ?>">
        <tr>
            <td>Пациент</td>
            <td>Врач</td>
            <td>Сотрудник</td>
            <td>Время назначения</td>
            <td>Содержание назначения</td>
            <td>Первичный</td>
        </tr>
        <?php foreach ($appointmentStatistic->appointmentsMadeOnDate as $appointment): ?>
            <tr>
                <td><?= Html::a($appointment->patient->fullName, ['/patient/manage/update', 'patient_id' => $appointment->patient->id], ['target' => '_blanc']) ?></td>
                <td><?= $appointment->appointments_day->doctor->fullName ?></td>
                <td><?= $appointment->employee->fullName ?></td>
                <td><?= $appointment->appointments_day->date ?><br><?= $appointment->NachNaz ?>-<?= $appointment->OkonchNaz ?></td>
                <td><?= $appointment->appointment_content ?></td>
                <td><?= $appointment->isInitialOnDate() ? 'Первичный' : 'Повторный' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endforeach; ?>