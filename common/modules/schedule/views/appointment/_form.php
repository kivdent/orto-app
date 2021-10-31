<?php

use common\modules\patient\models\Patient;
use common\modules\patient\widgets\PatientFindModalWidget;
use common\modules\schedule\models\AppointmentContent;
use common\modules\schedule\models\AppointmentsDay;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\Appointment */
/* @var $form yii\widgets\ActiveForm */
/* @var $appointment_day AppointmentsDay */
?>

<div class="appointment-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="hidden">
        <?= $form->field($model, 'PatID')->textInput(['id' => 'patient_id']) ?></div>
    <div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="patient_id_input_group">Пациент</label>
            <div class="input-group" id="patient_id_input_group">

                <input type="text" disabled="disabled" class="form-control" id="patient_name">
                <span class="input-group-btn">
                 <button class="btn btn-default modal-open" type="button">Выбрать</span></button>
                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-plus"
                                                                    aria-hidden="true"></span></button>
                <?= PatientFindModalWidget::widget([
                    'patientNameTarget' => '#patient_name',
                    'patientIdTarget' => '#patient_id'
                ]) ?>
                </span>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-3"> <?= $form->field($model, 'NachNaz')->textInput(['readonly' => 'readonly']) ?></div>
        <div class="col-lg-3"> <?= $form->field($model, 'OkonchNaz')->dropDownList(AppointmentsDay::getTimeListForNextAppointment($appointment_day->vrachID, strtotime($appointment_day->date . ' ' . $model->NachNaz . ':00'), $model->NachNaz)) ?></div>
    </div>
    <div class="row">

        <div class="col-lg-6"> <?= $form->field($model, 'SoderzhNaz')->dropDownList(AppointmentContent::getContentList()) ?></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

