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

$this->title = "Статистика записей пациентов";
?>
<h1><?= $this->title ?></h1>
<div class="row">
    <div class="col-lg-12">
        <?= \common\modules\schedule\widgets\TimeAppointmentChooser::widget([
            'start_date' => $start_date,
//        'patient_id' => $patient_id,
//        'doctor_id' => $doctor_id,
            'base_link' => '/statistics/appointment/appointments-stats',
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
                                        <?php foreach ($appointmentStatistic->appointmentsOnDate as $appointment): ?>
                                            <?php $control_time = strtotime(date('d.m.Y', $appointment->unixDate) . ' 16:00:00'); ?>

                                            <tr>
                                                <td><?= Html::a($appointment->patient->fullName, ['/patient/manage/update', 'patient_id' => $appointment->patient->id], ['target' => '_blanc']) ?></td>
                                                <td><?= $appointment->appointments_day->doctor->fullName ?></td>
                                                <td><?= $appointment->employee->fullName ?></td>
                                                <td><?= $appointment->appointments_day->date ?>
                                                    <br><?= $appointment->NachNaz ?>
                                                    -<?= $appointment->OkonchNaz ?>
                                                    <br><?= date('d.m.Y H:i:s', $appointment->unixDate) ?>
                                                    -<?= date('d.m.Y H:i:s', $control_time) ?>
                                                </td>
                                                <td><?= $appointment->appointment_content ?></td>
                                                <td><?= $appointment->initialDateFlag ? 'Первичный' : 'Повторный' ?></td>
                                            </tr>

                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                                data-target="#all_<?= $appointmentStatistic->date->format('d_m_Y') ?>">
                            <?= $appointmentStatistic->countAppointment ?>
                        </button>
                    </td>


                    <?php
                    $count_all += $appointmentStatistic->countAppointment;
                    $all_appoint = array_merge($all_appoint, $appointmentStatistic->appointmentsOnDate);
                    ?>
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
                                    <?php foreach ($all_appoint as $appointment): ?>

                                        <tr>
                                            <td><?= Html::a($appointment->patient->fullName, ['/patient/manage/update', 'patient_id' => $appointment->patient->id], ['target' => '_blanc']) ?></td>
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
            </tr>
            <tr class="all_init">
                <td>Первичных</td>

                <?php foreach ($appointmentStatistics as $appointmentStatistic): ?>
                    <td>
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
                                        <?php $d = 0 ?>
                                        <?php foreach ($appointmentStatistic->appointmentsOnDate as $appointment): ?>
                                            <?php $control_time = strtotime(date('d.m.Y', $appointment->unixDate) . ' 16:00:00');; ?>
                                            <?php if ($appointment->unixDate >= $control_time): ?>
                                                <?php
                                                $d++;
                                                $init_app []= $appointment;
                                                $count_init++;
                                                ?>
                                                <tr>
                                                    <td><?= $d . ' ' . Html::a($appointment->patient->fullName, ['/patient/manage/update', 'patient_id' => $appointment->patient->id], ['target' => '_blanc']) ?></td>
                                                    <td><?= $appointment->appointments_day->doctor->fullName ?></td>
                                                    <td><?= $appointment->employee->fullName ?></td>
                                                    <td><?= $appointment->appointments_day->date ?>
                                                        <br><?= $appointment->NachNaz ?>
                                                        -<?= $appointment->OkonchNaz ?>
                                                    <td><?= $appointment->appointment_content ?></td>
                                                    <td><?= $appointment->initialDateFlag ? 'Первичный' : 'Повторный' ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                                data-target="#init_<?= $appointmentStatistic->date->format('d_m_Y') ?>">
                            <?= $d ?>
                        </button>
                    </td>


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
                                    <?php foreach ($init_app as $appointment): ?>

                                        <tr>
                                            <td><?= Html::a($appointment->patient->fullName, ['/patient/manage/update', 'patient_id' => $appointment->patient->id], ['target' => '_blanc']) ?></td>
                                            <td><?= $appointment->appointments_day->doctor->fullName ?></td>
                                            <td><?= $appointment->employee->fullName ?></td>
                                            <td><?= $appointment->appointments_day->date ?>
                                                <br><?= $appointment->NachNaz ?>
                                                -<?= $appointment->OkonchNaz ?></td>
                                            <td><?= $appointment->appointment_content ?></td>

                                            <td><?= $appointment->employeePositionName ?></td>
                                            <td><?= $appointment->appointmentResultLabel ?></td>
                                            <td><?= $appointment->patientTreamentPlansCount ?></td>
                                            <td><?= $appointment->countDoctors ?></td>
                                        </tr>

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