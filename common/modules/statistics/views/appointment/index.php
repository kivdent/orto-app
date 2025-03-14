<?php
/* @var $this yii\web\View */

/* @var  $appointmentStatistics AppointmentStatistics[] */
/* @var  $start_date string */

/* @var  $duration integer */

use common\modules\statistics\models\AppointmentStatistics;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;

$count_all = 0;
$count_init = 0;

$all_appoint = [];
$init_app = [];

$this->title = "Статистика назначений, сделанных администратором";
?>
<h1><?= $this->title ?></h1>
<div class="row">
    <div class="col-lg-12">
        <?= \common\modules\schedule\widgets\TimeAppointmentChooser::widget([
            'start_date' => $start_date,
//        'patient_id' => $patient_id,
//        'doctor_id' => $doctor_id,
            'base_link' => '/statistics/appointment/index',
            'duration' => $duration,
        ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered">
            <tr class="date">
                <td></td>
                <?php foreach ($appointmentStatistics as $appointmentStatistic): ?>
                    <td>
                        <?= $appointmentStatistic->date->format('d.m.Y') ?>
                    </td>
                <?php endforeach; ?>
                <td>Итого</td>
            </tr>
            <tr class="all_appoint">
                <td>Всего</td>
                <?php foreach ($appointmentStatistics as $appointmentStatistic): ?>

                    <td>
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                                data-target="#all_<?= $appointmentStatistic->date->format('d_m_Y') ?>">
                            <?= $appointmentStatistic->countAppointment ?>
                        </button>

                        <div class="modal fade bs-example-modal-lg"
                             id="all_<?= $appointmentStatistic->date->format('d_m_Y') ?>" tabindex="-1"
                             role="dialog"
                             aria-labelledby="all_<?= $appointmentStatistic->date->format('d_m_Y') ?>">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <table class="table"
                                           id="table_appointment_<?= $appointmentStatistic->date->format('d-m-Y') ?>">
                                        <tr>
                                            <td>Пациент</td>
                                            <td>Врач</td>
                                            <td>Сотрудник</td>
                                            <td>Время назначения</td>
                                            <td>Содержание назначения</td>
                                            <td>Первичный</td>
                                        </tr>

                                        <?php foreach ($appointmentStatistic->appointmentsMadeOnDate as $appointment): ?>
                                            <?php $all_appoint [] = $appointment; ?>

                                                <tr>
                                                    <td><?=Html::a($appointment->patient->fullName, ['/patient/manage/update', 'patient_id' => $appointment->patient->id], ['target' => '_blanc']) ?></td>
                                                    <td><?= $appointment->appointments_day->doctor->fullName ?></td>
                                                    <td><?= $appointment->employee->fullName ?></td>
                                                    <td><?= $appointment->appointments_day->date ?>
                                                        <br><?= $appointment->NachNaz ?>
                                                        -<?= $appointment->OkonchNaz ?></td>
                                                    <td><?= $appointment->appointment_content ?></td>
                                                    <td><?= $appointment->initialDateFlag ? 'Первичный' : 'Повторный' ?></td>
                                                </tr>

                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </td>

                    <?php $count_all += $appointmentStatistic->countAppointment; ?>

                <?php endforeach; ?>
                <td>
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                            data-target="#all_count">
                        <?= $count_all ?>
                    </button>
                    <div class="modal fade bs-example-modal-lg"
                         id="all_count" tabindex="-1"
                         role="dialog"
                         aria-labelledby="all_count">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <table class="table"
                                       id="table_appointment_<?= $appointmentStatistic->date->format('d-m-Y') ?>">
                                    <tr>
                                        <td>Пациент</td>
                                        <td>Врач</td>
                                        <td>Сотрудник</td>
                                        <td>Время назначения</td>
                                        <td>Содержание назначения</td>
                                        <td>Первичный</td>
                                    </tr>
                                    <?php $i=1 ?>
                                    <?php foreach ($all_appoint as  $appointment): ?>

                                            <tr>
                                                <td><?= $i . ' ' . Html::a($appointment->patient->fullName, ['/patient/manage/update', 'patient_id' => $appointment->patient->id], ['target' => '_blanc']) ?></td>
                                                <td><?= $appointment->appointments_day->doctor->fullName ?></td>
                                                <td><?= $appointment->employee->fullName ?></td>
                                                <td><?= $appointment->appointments_day->date ?>
                                                    <br><?= $appointment->NachNaz ?>
                                                    -<?= $appointment->OkonchNaz ?></td>
                                                <td><?= $appointment->appointment_content ?></td>
                                                <td><?= $appointment->initialDateFlag ? 'Первичный' : 'Повторный' ?></td>
                                            </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="all_init">
                <td>Первичных</td>

                <?php foreach ($appointmentStatistics as $appointmentStatistic): ?>
                    <td>

                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                                data-target="#init_<?= $appointmentStatistic->date->format('d_m_Y') ?>">
                            <?= $appointmentStatistic->initialAppointment ?>
                        </button>


                        <div class="modal fade bs-example-modal-lg"
                             id="init_<?= $appointmentStatistic->date->format('d_m_Y') ?>" tabindex="-1"
                             role="dialog"
                             aria-labelledby="all_<?= $appointmentStatistic->date->format('d_m_Y') ?>">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <table class="table">
                                        <tr>
                                            <td>Пациент</td>
                                            <td>Врач</td>
                                            <td>Сотрудник</td>
                                            <td>Время назначения</td>
                                            <td>Содержание назначения</td>
                                            <td>Первичный</td>
                                        </tr>
                                        <?php foreach ($appointmentStatistic->appointmentsMadeOnDate as $appointment): ?>
                                            <?php if ($appointment->initialDateFlag): ?>
                                                <?php $init_app[] = $appointment ?>
                                                <tr>
                                                    <td><?= Html::a($appointment->patient->fullName, ['/patient/manage/update', 'patient_id' => $appointment->patient->id], ['target' => '_blanc']) ?></td>
                                                    <td><?= $appointment->appointments_day->doctor->fullName ?></td>
                                                    <td><?= $appointment->employee->fullName ?></td>
                                                    <td><?= $appointment->appointments_day->date ?>

                                                    <td><?= $appointment->appointment_content ?></td>
                                                    <td><?= $appointment->initialDateFlag ? 'Первичный' : 'Повторный' ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </td>
                    <?php $count_init += $appointmentStatistic->initialAppointment ?>

                <?php endforeach; ?>

                <td>

                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                            data-target="#count_init">
                        <?= $count_init ?>
                    </button>
                    <div class="modal fade bs-example-modal-lg"
                         id="count_init" tabindex="-1"
                         role="dialog"
                         aria-labelledby="count_init">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <table class="table">
                                    <tr>
                                        <td>Пациент</td>
                                        <td>Врач</td>
                                        <td>Сотрудник</td>
                                        <td>Время назначения</td>
                                        <td>Содержание назначения</td>
                                        <td>Специальность врача</td>
                                        <td>Явка/Отмена/Перенос</td>
                                        <td>План лечения</td>
                                        <td>Количество спецов</td>

                                    </tr>
                                    <?php $i=0?>
                                    <?php foreach ($init_app as $appointment): ?>
                                        <?php if ($appointment->initialDateFlag): ?>
                                            <?php $i++?>
                                            <tr>
                                                <td><?= $i.' '.Html::a($appointment->patient->fullName, ['/patient/manage/update', 'patient_id' => $appointment->patient->id], ['target' => '_blanc']) ?></td>
                                                <td><?= $appointment->appointments_day->doctor->fullName ?></td>
                                                <td><?= $appointment->employee->fullName ?></td>
                                                <td><?= $appointment->appointments_day->date. ' '.$appointment->unixDate ?>
                                                <td><?= $appointment->appointment_content ?></td>
                                                <td><?=$appointment->employeePositionName?></td>
                                                <td><?= $appointment->appointmentResultLabel?></td>
                                                <td><?=$appointment->patientTreamentPlansCount?></td>
                                                <td><?=$appointment->countDoctors?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </td>

            </tr>
        </table>
    </div>
</div>
