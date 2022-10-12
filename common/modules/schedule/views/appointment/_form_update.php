<?php

use common\modules\patient\models\Patient;
use common\modules\patient\widgets\PatientFindModalWidget;
use common\modules\schedule\models\AppointmentContent;
use common\modules\schedule\models\AppointmentsDay;

use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\Appointment */
/* @var $form yii\widgets\ActiveForm */
/* @var $appointment_day AppointmentsDay */
//UserInterface::getVar($appointment_day->date . ' ' . $model->NachNaz );
?>

<div class="appointment-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="hidden"><?= $form->field($model, 'PatID')->textInput(['id' => 'patient_id']) ?></div>

    <div class="row">
        <div class="col-lg-3"> <?= $form->field($model, 'NachNaz')->textInput(['readonly' => 'readonly']) ?></div>
        <div class="col-lg-3"> <?= $form->field($model, 'OkonchNaz')->dropDownList(AppointmentsDay::getTimeListForNextAppointment($appointment_day->vrachID, strtotime($appointment_day->date . ' ' . $model->NachNaz ), $model->NachNaz)) ?></div>
    </div>

    <div class="row">
        <div class="col-lg-6"> <?= $form->field($model, 'SoderzhNaz')->dropDownList(AppointmentContent::getContentList()) ?></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

