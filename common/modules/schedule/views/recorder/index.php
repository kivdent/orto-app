<?php
/* @var $this yii\web\View */

/* @var $appointmentManager AppointmentDayManager[] */

/* @var $appointment Appointment */
/* @var $start_date string */

/* @var $options [] */


use common\modules\schedule\assets\RecorderAsset;
use common\modules\schedule\controllers\RecorderController;
use common\modules\schedule\models\Appointment;
use common\modules\schedule\models\AppointmentDayManager;
use common\modules\schedule\models\AppointmentManager;
use common\modules\schedule\widgets\AppointmentModalWidget;
use common\modules\userInterface\models\UserInterface;
use common\modules\userInterface\widgets\ScheduleAlertsWidgets;
use common\widgets\ButtonsWidget\AppointmentButtonsWidget;
use common\widgets\ButtonsWidget\ButtonsWidget;
use common\widgets\ButtonsWidget\FreeTimeButton;
use common\widgets\ButtonsWidget\InvoiceActionsButtonWidget;
use common\widgets\ButtonsWidget\ScheduleAlertButtonsWidget;
use kartik\date\DatePicker;
use yii\helpers\Html;

$this->title = 'Пациенты на сегодня';
RecorderAsset::register($this);
?>

<h1><?= $this->title ?></h1>
<div class="row">
    <?php if ($options['doctor_chooser'] == RecorderController::ELEMENT_SHOW): ?>
        <div class="doctor_chooser col-lg-2">

            <?=\common\modules\schedule\widgets\DoctorChooserWidget::widget()?>
        </div>
    <?php endif; ?>
    <?php if ($options['full_table_chooser'] == RecorderController::ELEMENT_SHOW): ?>
        <div class="full_table_chooser col-lg-3">

            <?=\common\modules\schedule\widgets\FullTableChooserWidget::widget()?>
        </div>
    <?php endif; ?>
    <?php if ($options['day_chooser'] == RecorderController::ELEMENT_SHOW): ?>
        <div class="day_chooser col-lg-4">
            <div class="input-group">
            <span class="input-group-btn">
       <?= Html::a('<span class="glyphicon glyphicon-triangle-left"></span>',
           [
               '/schedule/recorder/' . Yii::$app->controller->action->id,
               'start_date' => date('d.m.Y', strtotime($start_date . ' - 1 day')),
           ],
           [
               'class' => 'btn btn-primary',
               'id' => 'back',
           ]) ?>
            </span>
                <?=
                DatePicker::widget([
                    'name' => 'datePicker',
                    'value' => $start_date,
                    //'type' => DatePicker::TYPE_BUTTON,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd.mm.yyyy'
                    ],
                    'removeButton' => false,
                    'options' => [
                        'id' => 'datePicker',
                        'class' => 'form-control',
//                    'patient_id' => $patient_id ? $patient_id : 'null',
//                    'doctor_ids' => $doctor_id,
                        'start_date' => $start_date,
                        'action' => Yii::$app->controller->action->id,
                    ]
                    //'buttonOptions' =>'btn btn-primary'
                ])
                ?>
                <span class="input-group-btn">
        <?= Html::a(' <span class="glyphicon glyphicon-triangle-right"></span>',
            ['/schedule/recorder/' . Yii::$app->controller->action->id,
                'start_date' => date('d.m.Y', strtotime($start_date . ' + 1 day')),
            ]
            , ['class' => 'btn btn-primary',
                'id' => 'forward',]) ?>
            </span>
            </div>
        </div>
    <?php endif; ?>
    <?php if (UserInterface::isUserRole(UserInterface::ROLE_RECORDER) || UserInterface::isUserRole(UserInterface::ROLE_SENIOR_RECORDER)): ?>
        <?= Html::a('Звонок', ['/schedule/incoming-calls/create'], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
    <?php endif; ?>
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
                                    <h4><?= \frontend\models\Employe::findOne($doctorId)->fullName ?>
                                        <?= FreeTimeButton::widget(['doctor_id' => $doctorId, 'start_date' => $start_date, 'url' => '/schedule/recorder/' . Yii::$app->controller->action->id,]) ?>
                                    </h4>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="row">
                            <?php foreach ($appointmentDayManager->appointmentsDays as $appointmentDay): ?>
                                <div class="col-lg-12">
                                    <?php if (!$appointmentDay->isHoliday): ?>
                                        <?= Html::button('История назначений', [
                                            'class' => 'btn btn-info btn-xs',
                                            'data-toggle' => "modal",
                                            'data-target' => "#modal-History-" . $appointmentDay->appointmentsDay->id]) ?>

                                        <div class="modal fade"
                                             id=<?= "modal-History-" . $appointmentDay->appointmentsDay->id ?> tabindex="-1"
                                             role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">История назначений</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="appointments">
                                                            <?php foreach ($appointmentDay->appointmentDayHistory as $appoitment): ?>

                                                                <div class="row <?= Appointment::getRowClass($appoitment) ?>">
                                                                    <div class="col-lg-2">
                                                                        <?php if ($appoitment->status === Appointment::STATUS_CANCEL): ?>
                                                                            <span class="label label-danger">Запись отменена</span>
                                                                        <?php endif; ?><?= UserInterface::getFormatedDate($appoitment->appointments_day->date) ?>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <?= UserInterface::getFormattedTime($appoitment->NachNaz) ?>
                                                                        -<?= UserInterface::getFormattedTime($appoitment->OkonchNaz) ?>
                                                                    </div>
                                                                    <div class="col-lg-2">

                                                                        <?= $appoitment->patient ? Html::a($appoitment->patient->fullName,['/patient/appointments','patient_id'=>$appoitment->patient->id],['target'=>'_blank']) : 'Не известно' ?>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <?= $appoitment->appointment_content ?>
                                                                    </div>

                                                                    <div class="col-lg-2">
                                                                        <?= $appoitment->info ?>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Закрыть
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endif; ?>

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
                                                        <td colspan="4">
                                                            <?= AppointmentModalWidget::widget([
                                                                'appointment_day_id' => 'new',
                                                                'doctor_id' => $appointmentDay->appointmentsDay->vrachID,
                                                                'date' => $appointmentDay->appointmentsDay->date,
                                                                'time' => date('H:i', $time),
                                                                'patient_id' => null,

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
                                                                                'target' => '_blank',
                                                                                'title' => 'Номер карты: ' . $appointment->patient->id
                                                                            ]) ?> <span
                                                                                class="label label-default"><?= $appointment->patient->id ?></span><br>
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
                                                                'appointmentId' => $appointment->Id,
                                                                'style' => ButtonsWidget::STYLE_DROPDOWN,
                                                                'label' => 'Счёт'
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
                                                            <?php else: ?>
                                                                <br>
                                                                <span class="label label-info">
                                                                <?= $appointment->noticeResult->RezObzv ?>
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