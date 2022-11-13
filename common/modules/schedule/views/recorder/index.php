<?php
/* @var $this yii\web\View */

/* @var $appointmentManager AppointmentDayManager[] */

/* @var $appointment Appointment */


use common\modules\notifier\assets\NotifierAsset;
use common\modules\schedule\assets\RecorderAsset;
use common\modules\schedule\models\Appointment;
use common\modules\schedule\models\AppointmentDayManager;
use common\modules\schedule\models\AppointmentManager;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;

$this->title = 'Пациенты на сегодня';
RecorderAsset::register($this);
?>

<h1><?= $this->title ?></h1>
<div class="doctor-chooser row">

    <div class="col-lg-2">
        <?= Html::dropDownList('doctor_id', '', AppointmentManager::getActiveDoctorsNameList(''),
            [
                'id' => 'doctor_id',
                'class' => 'form-control',
            ]
        );
        ?></div>
    <div class="col-lg-3">
        <?= Html::dropDownList('full_table', 'appointment', ['full' => 'Полное расписание', 'empty' => 'Свободные часы', 'appointment' => 'Назначенные',],
            [
                'id' => 'full_table',
                'class' => 'form-control',
            ]
        );
        ?></div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="schedule-table">
            <?php foreach ($appointmentManager as $doctorId => $appointmentDayManager): ?>
                <div class="row doctor-grid" id="doctor-grid-id-<?= $doctorId ?>">
                    <div class="col-lg-12">
                        <?php if (AppointmentManager::haveWorkDays($appointmentDayManager->appointmentsDays)): ?>
                            <div class="row doctor-name">
                                <div class="col-lg-12">
                                    <h4><?= \frontend\models\Employe::findOne($doctorId)->fullName ?></h4>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="row">
                            <?php foreach ($appointmentDayManager->appointmentsDays as $appointmentDay): ?>
                                <div class="col-lg-12">
                                    <table class="table table-bordered">
                                        <?php if (!$appointmentDay->isHoliday): ?>
                                            <?php foreach ($appointmentDay->grid as $time => $appointment): ?>
                                                <tr <?= $appointment == AppointmentDayManager::TIME_EMPTY ? 'class=empty' : 'class=appointment' ?>>
                                                    <td class="col-lg-2">
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <?= date('H:i', $time) ?>
                                                            </div>
                                                        </div>
                                                        <?php if ($appointment != AppointmentDayManager::TIME_EMPTY): ?>
                                                            <div class="load" hidden>
                                                                    <span class="glyphicon glyphicon-refresh"
                                                                          aria-hidden="true">
                                                                    </span>
                                                            </div>
                                                            <div class="presence"
                                                                 appointment_id="<?= $appointment->Id ?>">
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <?php if ($appointment == AppointmentDayManager::TIME_EMPTY): ?>
                                                        <td colspan="3">
                                                            <?= Html::a('Назначить', ['/schedule/appointment/create',
                                                                'appointment_day_id' => 'new',
                                                                'doctor_id' => $appointmentDay->appointmentsDay->vrachID,
                                                                'date' => $appointmentDay->appointmentsDay->date,
                                                                'time' => $time,
                                                            ],
                                                                [
                                                                    'target' => '_blank'
                                                                ]) ?>
                                                        </td>

                                                    <?php else: ?>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <?= Html::a($appointment->patient->fullName,
                                                                        [
                                                                            '/patient/manage/update',
                                                                            'patient_id' => $appointment->patient->id,
                                                                        ],
                                                                        [
                                                                            'target' => '_blank'
                                                                        ]) ?><br>
                                                                    <small> <?= $appointment->appointment_content ?></small>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="btn-group" role="group">
                                                                        <?= Html::a(' <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>', [
                                                                            '/schedule/appointment/cancel',
                                                                            'appointmentId' => $appointment->Id,],
                                                                            ['class' => 'btn btn-xs btn-danger',
                                                                                'data' => ['confirm' => 'Вы уверены что хотите отменить пациента?',
                                                                                    'method' => 'post',],
                                                                                'title' => 'Отменить',
                                                                                'target' => '_blank'
                                                                            ]);
                                                                        ?>
                                                                        <?= Html::a(' <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>', [
                                                                            '/schedule/appointment/index',
                                                                            'patient_id' => $appointment->patient->id,],
                                                                            ['class' => 'btn btn-xs btn-info',
                                                                                'title' => 'Назначить',
                                                                                'target' => '_blank'

                                                                            ]);
                                                                        ?>
                                                                        <?= Html::a(' <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', [
                                                                            '/schedule/appointment/update',
                                                                            'appointmentId' => $appointment->Id,],
                                                                            ['class' => 'btn btn-xs btn-info',
                                                                                'data' => ['method' => 'post',],
                                                                                'title' => 'Изменить время',
                                                                                'target' => '_blank'
                                                                            ]);
                                                                        ?>
                                                                        <?= Html::a(
                                                                            '<span class="glyphicon glyphicon-rub" aria-hidden="true"></span>',
                                                                            [
                                                                                '/invoice/manage/create',
                                                                                'patient_id' => $appointment->PatID,
                                                                                'appointment_id' => $appointment->Id,
                                                                                'invoice_type' => \common\modules\invoice\models\Invoice::TYPE_MATERIALS],
                                                                            ['class' => 'btn btn-xs btn-info',
                                                                                'title' => 'Выписать счёт',
                                                                                'target' => '_blank']
                                                                        ); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="col-lg-3">
                                                            <div class="load" hidden>
                                                                    <span class="glyphicon glyphicon-refresh"
                                                                          aria-hidden="true">
                                                                    </span>
                                                            </div>
                                                            <div class="notice-result" appointment_id="<?= $appointment->Id ?>">

                                                            </div>
                                                        </td>
                                                        <td class="col-lg-2">
                                                            <small><?= $appointment->patient->MTel ?></small>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </table>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>