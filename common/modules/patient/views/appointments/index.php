<?php
/* @var $this yii\web\View */

/* @var $appoitments Appointment[] */

use common\modules\patient\models\Patient;
use common\modules\schedule\models\Appointment;
use common\modules\userInterface\models\UserInterface;
use common\widgets\ButtonsWidget\AppointmentButtonsWidget;
use yii\helpers\Html;

$this->title = 'Назначения пациента ' . Patient::findOne(Yii::$app->request->get('patient_id'))->fullName;
\common\modules\schedule\assets\AppointmentAsset::register($this);
?>
<h1>Назначения <?= Html::a('Назначить', [
        '/schedule/appointment/index',
        'patient_id' => Yii::$app->request->get('patient_id'),
    ],
        [
            'class' => 'btn btn-info',
            'title' => 'Назначить',
            'target'=>'_blank'
        ]);
    ?></h1>
<div>

</div>
<div class="appointments">
    <?php foreach ($appoitments as $appoitment): ?>

        <div class="row <?= (int)strtotime((UserInterface::getFormatedDate($appoitment->appointments_day->date))) <= (int)strtotime('now') ? 'bg-warning' : 'bg-info'; ?>">
            <div class="col-lg-1">
                <?= UserInterface::getFormatedDate($appoitment->appointments_day->date) ?>
                <?php if ($appoitment->status === Appointment::STATUS_CANCEL): ?>
                    <span class="label label-danger">Запись отменена</span>
                <?php endif; ?>
            </div>
            <div class="col-lg-2">
                <?= UserInterface::getFormattedTime($appoitment->NachNaz) ?>
                -<?= UserInterface::getFormattedTime($appoitment->OkonchNaz) ?>
            </div>
            <div class="col-lg-3">
                <?= $appoitment->appointments_day->doctor ? $appoitment->appointments_day->doctor->fullName : 'Не известно' ?>
            </div>
            <div class="col-lg-2">
                <?= $appoitment->appointment_content ?>
            </div>
            <div class="col-lg-4">
                <?php if ($appoitment->status === Appointment::STATUS_ACTIVE): ?>

                    <?= Html::button(' <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>',
                        ['class' => 'btn btn-xs btn-danger btn-remove-appointment',
                            'data' => ['confirm' => 'Вы уверены что хотите отменить пациента?',
                            ],
                            'title' => 'Отменить',
                            //'id'=>'remove-appointment',
                            'appointmentId' => $appoitment->Id
                        ]);
                    ?>
                    <?= Html::a(' <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', [
                        '/schedule/appointment/update',
                        'appointmentId' => $appoitment->Id,],
                        [
                            'class' => 'btn btn-xs btn-success',
                            'data' => [
                                'method' => 'post',
                            ],
                            'title' => 'Изменить',
                        ]);
                    ?>
                    <?= AppointmentButtonsWidget::widget([
                        'appointmentId' => $appoitment->Id,
                    ]) ?>
                <?php else: ?>
                    Запись отменена
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>