<?php
/* @var $this yii\web\View */

/* @var $appoitments Appointment[] */

use common\modules\patient\models\Patient;
use common\modules\schedule\models\Appointment;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;
$this->title='Назначения пациента '. Patient::findOne(Yii::$app->request->get('patient_id'))->fullName;
?>
<h1>Назначения <?= Html::a('Назначить', [
        '/schedule/appointment/index',
        'patient_id' => Yii::$app->request->get('patient_id'),
    ],
        [
            'class' => 'btn btn-info',
            'title' => 'Назначить',
        ]);
    ?></h1>
<div>

</div>
<div class="appitments">
    <?php foreach ($appoitments as $appoitment): ?>
        <div class="row">
            <div class="col-lg-1">
                <?= UserInterface::getFormatedDate($appoitment->appointments_day->date) ?>
                <?php if ($appoitment->status === Appointment::STATUS_CANCEL): ?>
                    <span class="label label-danger">Запись отменена</span>
                <?php endif; ?>
            </div>
            <div class="col-lg-2">
                <?= UserInterface::getFormattedTime($appoitment->NachNaz) ?>-<?= UserInterface::getFormattedTime($appoitment->OkonchNaz) ?>
            </div>
            <div class="col-lg-3">
                <?= $appoitment->appointments_day->doctor?$appoitment->appointments_day->doctor->fullName:'Не известно' ?>
            </div>
            <div class="col-lg-2">
                <?= $appoitment->appointment_content ?>
            </div>
            <div class="col-lg-4">
                <?php if ($appoitment->status === Appointment::STATUS_ACTIVE): ?>
                    <?= Html::a(' <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>', [
                        '/schedule/appointment/cancel',
                        'appointmentId' => $appoitment->Id,],
                        [
                            'class' => 'btn btn-xs btn-danger',
                            'data' => [
                                'confirm' => 'Вы уверены что хотите отменить пациента?',
                                'method' => 'post',
                            ],
                            'title' => 'Отменить'
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
                <?php else: ?>
                    Запись отменена
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>


