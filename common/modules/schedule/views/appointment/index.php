<?php
/* @var $start_date string */
/* @var $this yii\web\View */
/* @var $appointmentManager AppointmentDayManager[] */
/* @var $row Appointment */
/* @var $doctor_id string */
/* @var $patient_id string */
/* @var $duration integer */

/* @var  $full_table boolean */


use common\modules\schedule\assets\AppointmentAsset;
use common\modules\schedule\models\Appointment;
use common\modules\schedule\models\AppointmentDayManager;
use common\modules\schedule\models\AppointmentManager;
use common\modules\schedule\models\BaseSchedules;
use common\modules\schedule\models\ScheduleManager;
use common\modules\userInterface\models\UserInterface;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

AppointmentAsset::register($this);
if ($patient_id=='null') $patient_id=null;
if ($patient_id) {
    $patient = \common\modules\patient\models\Patient::findOne($patient_id);
    $this->title = 'Назначение пациента ' . $patient->fullName;
} else {
    $this->title = 'Назначение пациентов';
}
$additionalTextStartDate = Url::to(['/schedule/appointment',
        'patient_id' => $patient_id,
        'doctor_ids' => $doctor_id,
    ]) . '&start_date=';
$additionalTextDoctorIds = Url::to([
        '/schedule/appointment',
        'patient_id' => $patient_id,
        'doctor_ids' => $doctor_id,
        'start_date' => date('d.m.Y', strtotime($start_date . ' -' . $duration . ' days')),
    ]) . '&doctor_ids=';
?>
<div class="row">
    <div class="col-lg-12">
        <h3><?= $this->title ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h3><?= $this->title ?></h3>
    </div>
</div>

<div class="doctor-chooser row">
    <div class="col-lg-2">
        <?= Html::dropDownList('doctor_id', $additionalTextDoctorIds . $doctor_id, AppointmentManager::getActiveDoctorsNameList($additionalTextDoctorIds),
            [
                'id' => 'doctor_id',
                'class' => 'form-control',
            ]
        );
        ?></div>
    <div class="col-lg-2">
        <?= Html::dropDownList('full_table', $full_table, [1 => 'Полное расписание', 0 => 'Свободные часы'],
            [
                'id' => 'full_table',
                'class' => 'form-control',
            ]
        );
        ?></div>
    <div class="col-lg-4">
        <div class="input-group">
            <span class="input-group-btn">
       <?= Html::a('<span class="glyphicon glyphicon-triangle-left"></span>',
           [
               '/schedule/appointment',
               'start_date' => date('d.m.Y', strtotime($start_date . ' -' . $duration . ' days')),
               'patient_id' => $patient_id,
               'doctor_ids' => $doctor_id,
           ],
           [
               'class' => 'btn btn-primary',
               'id' => 'back',
           ]) ?>
            </span>
            <?php
            //            Html::dropDownList('month-list',
            //                $additionalTextStartDate,
            //                AppointmentManager::getMonthList($start_date, $additionalTextStartDate),
            //                [
            //                    'id' => 'month-list',
            //                    'class' => 'form-control',
            //                    'patient_id' => $patient_id,
            //                    'doctor_ids' => $doctor_id,
            //                ]
            //            );
            ?>
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
                    'patient_id' => $patient_id ? $patient_id : 'null',
                    'doctor_ids' => $doctor_id,
                    'start_date' => $start_date,
                ]
                //'buttonOptions' =>'btn btn-primary'
            ])
            ?>
            <span class="input-group-btn">
        <?= Html::a(' <span class="glyphicon glyphicon-triangle-right"></span>',
            ['/schedule/appointment',
                'start_date' => date('d.m.Y', strtotime($start_date . ' +' . $duration . ' days')),
                'patient_id' => $patient_id,
                'doctor_ids' => $doctor_id,
            ]
            , ['class' => 'btn btn-primary',
                'id' => 'forward',]) ?>
            </span>
        </div>
    </div>
</div>
<div class="schedule-table">
    <?php foreach ($appointmentManager as $doctorId => $appointmentDayManager): ?>
        <?php //\common\modules\userInterface\models\UserInterface::getVar($appointmentDayManager);?>
        <div class="row doctor-grid" id="doctor-grid-id-<?= $doctorId ?>">
            <div class="col-lg-12">
                <div class="row doctor-name">
                    <div class="col-lg-12">
                        <h4><?= \frontend\models\Employe::findOne($doctorId)->fullName ?></h4>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($appointmentDayManager->appointmentsDays as $appointmentDay): ?>
                        <div class="col-lg-2">
                            <table class="table table-bordered">
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
                                        <?= UserInterface::getFormatedDate($appointmentDay->date) ?><br>
                                        <?= UserInterface::getDayWeekNameByDate($appointmentDay->date) ?>
                                    </td>
                                </tr>
                                <?php if ($appointmentDay->isHoliday): ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>Выходной</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($appointmentDay->grid as $time => $row): ?>
                                        <tr <?= $row == AppointmentDayManager::TIME_EMPTY ? '' : 'class=appointment' ?>>
                                            <td>
                                                <?= date('H:i', $time) ?>
                                            </td>
                                            <td><?php if ($row == AppointmentDayManager::TIME_EMPTY): ?>

                                                    <?= Html::a('Назначить', ['create',
                                                        'appointment_day_id' => 'new',
                                                        'doctor_id' => $appointmentDay->appointmentsDay->vrachID,
                                                        'date' => $appointmentDay->appointmentsDay->date,
                                                        'time' => $time,
                                                        'patient_id' => $patient_id,]) ?>
                                                <?php else: ?>
                                                    <?= Html::a($row->patient->fullName, ['/patient/manage/update',
                                                        'patient_id' => $row->patient->id,],
                                                    [
                                                        'title' => 'Номер карты: '.$row->patient->id
                                                    ]) ?>
                                                    <br>
                                                    <?= Html::a(' <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>', ['cancel',
                                                        'appointmentId' => $row->Id,],
                                                        ['class' => 'btn btn-xs btn-danger',
                                                            'data' => ['confirm' => 'Вы уверены что хотите отменить пациента?',
                                                                'method' => 'post',],
                                                            'title' => 'Отменить']);
                                                    ?>
                                                    <?= Html::a(' <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>', ['index',
                                                        'patient_id' => $row->patient->id,],
                                                        ['class' => 'btn btn-xs btn-info',
                                                            'title' => 'Переназначить',
                                                        ]);
                                                    ?>
                                                    <?= Html::a(' <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['update',
                                                        'appointmentId' => $row->Id,],
                                                        ['class' => 'btn btn-xs btn-success',
                                                            'data' => ['method' => 'post',],
                                                            'title' => 'Изменить',]);
                                                    ?>
                                                <?php endif; ?>
                                            </td>
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