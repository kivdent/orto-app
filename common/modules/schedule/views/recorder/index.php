<?php
/* @var $this yii\web\View */

/* @var $appointmentManager AppointmentDayManager[] */

/* @var $appointment Appointment */
/* @var $start_date string */

/* @var $options [] */


use common\modules\notifier\assets\NotifierAsset;
use common\modules\schedule\assets\RecorderAsset;
use common\modules\schedule\controllers\RecorderController;
use common\modules\schedule\models\Appointment;
use common\modules\schedule\models\AppointmentDayManager;
use common\modules\schedule\models\AppointmentManager;
use common\modules\userInterface\models\UserInterface;
use common\modules\userInterface\widgets\ScheduleAlertsWidgets;
use common\widgets\ButtonsWidget\AppointmentButtonsWidget;
use common\widgets\ButtonsWidget\InvoiceActionsButtonWidget;
use common\widgets\ButtonsWidget\ScheduleAlertButtonsWidget;
use yii\helpers\Html;

$this->title = 'Пациенты на сегодня';
RecorderAsset::register($this);
?>

<h1><?= $this->title ?></h1>
<div class="row">
    <?php if ($options['doctor_chooser'] == RecorderController::ELEMENT_SHOW): ?>
        <div class="doctor_chooser col-lg-2">
            <?= Html::dropDownList('doctor_id', '', AppointmentManager::getActiveDoctorsNameList(''),
                [
                    'id' => 'doctor_id',
                    'class' => 'form-control',
                ]
            );
            ?></div>
    <?php endif; ?>
    <?php if ($options['full_table_chooser'] == RecorderController::ELEMENT_SHOW): ?>
        <div class="full_table_chooser col-lg-3">
            <?= Html::dropDownList('full_table', 'full', ['full' => 'Полное расписание', 'empty' => 'Свободные часы', 'appointment' => 'Назначенные',],
                [
                    'id' => 'full_table',
                    'class' => 'form-control',
                ]
            );
            ?></div>
    <?php endif; ?>
    <?php if ($options['day_chooser'] == RecorderController::ELEMENT_SHOW):?>
    <div class="day_chooser col-lg-4">
        <div class="input-group">
            <span class="input-group-btn">
       <?= Html::a('<span class="glyphicon glyphicon-triangle-left"></span>',
           [
               '/schedule/recorder',
               'start_date' => date('d.m.Y', strtotime($start_date . ' - 1 day')),

           ],
           [
               'class' => 'btn btn-primary',
               'id' => 'back',
           ]) ?>
            </span>
            <?= Html::dropDownList('month-list',
                $start_date,
                AppointmentManager::getDayList($start_date),
                [
                    'id' => 'month-list',
                    'class' => 'form-control',
                ]
            );
            ?>
            <span class="input-group-btn">
        <?= Html::a(' <span class="glyphicon glyphicon-triangle-right"></span>',
            ['/schedule/recorder',
                'start_date' => date('d.m.Y', strtotime($start_date . ' + 1 day')),
            ]
            , ['class' => 'btn btn-primary',
                'id' => 'forward',]) ?>
            </span>
        </div>
    </div>
    <?php endif;?>
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
                                <span class="col-lg-12">
                                    <table class="table table-bordered">
                                        <?php if (!$appointmentDay->isHoliday): ?>
                                            <?php foreach ($appointmentDay->grid as $time => $appointment): ?>
                                                <?php $tr_style = ($appointment != AppointmentDayManager::TIME_EMPTY && $appointment->Yavka === Appointment::PRESENCE_STATUS_APPEARED) ? 'success' : ''; ?>
                                                <tr <?= $appointment == AppointmentDayManager::TIME_EMPTY ? 'class=empty' : 'class=\'appointment ' . $tr_style . '\'' ?>>
                                                    <td class="col-lg-1">
                                                        <div class="row">
                                                            <div class="col-lg-1">
                                                                <?= date('H:i', $time) ?>
                                                            </div>
                                                        </div>
                                                        <?php if ($appointment != AppointmentDayManager::TIME_EMPTY
                                                            && ((UserInterface::isUserRole(UserInterface::ROLE_RECORDER)) ||
                                                                (UserInterface::isUserRole(UserInterface::ROLE_SENIOR_RECORDER)))): ?>
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
                                                                    <small><?= Html::a($appointment->patient->fullName,
                                                                            [
                                                                                '/patient/manage/update',
                                                                                'patient_id' => $appointment->patient->id,
                                                                            ],
                                                                            [
                                                                                'target' => '_blank'
                                                                            ]) ?><br>
                                                                        <?= $appointment->appointment_content ?></small>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <?= AppointmentButtonsWidget::widget([
                                                                        'appointmentId' => $appointment->Id,
                                                                    ]) ?>
                                                                </div>
                                                            </div>
                                                        </td>


                                                        <td class="col-lg-2 invoice-actions">
                                                            <?= InvoiceActionsButtonWidget::widget([
                                                                'appointmentId' => $appointment->Id
                                                            ]) ?>
                                                        </td>
                                                        <td class="col-lg-2 schedule-alert">
                                                            <?= ScheduleAlertButtonsWidget::widget([
                                                                'patient_id' => $appointment->PatID,
                                                                'employee_id' => Yii::$app->user->identity->employe->id
                                                            ]) ?>
                                                        </td>
                                                        <td class="col-lg-3">
                                                            <small><?= $appointment->patient->MTel ?></small>
                                                            <?php if ((UserInterface::isUserRole(UserInterface::ROLE_RECORDER)) ||
                                                                (UserInterface::isUserRole(UserInterface::ROLE_SENIOR_RECORDER))): ?>

                                                                <div class="load" hidden>
                                                                    <span class="glyphicon glyphicon-refresh"
                                                                          aria-hidden="true">
                                                                    </span>
                                                                </div>
                                                                <div class="notice-result"
                                                                     appointment_id="<?= $appointment->Id ?>">
                                                                </div>
                                                            <?php else:?>
                                                            <span class="label label-info">
                                                                <?=$appointment->noticeResult->RezObzv?>
                                                            </span>

                                                            <?php endif; ?>
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