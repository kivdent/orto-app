<?php

/* @var $this \yii\web\View */
/* @var $text string */
/* @var $appointment_day_id string */
/* @var $doctor_id string */
/* @var $date string */
/* @var $time string */
/* @var $patient_id string */

use common\assets\jQueryValidationAsset;
use common\modules\patient\widgets\assets\PatientFindModalAsset;
use common\modules\schedule\widgets\assets\AppointmentModalAsset;
use yii\helpers\Html;

AppointmentModalAsset::register($this);
PatientFindModalAsset::register($this);
jQueryValidationAsset::register($this)?>


<?= Html::button($text,[
    'class'=>"btn btn-link btn-appointment-modal-create",
    'appointment_day_id' => $appointment_day_id,
    'doctor_id' => $doctor_id,
    'date' => $date,
    'time' => $time,
    'patient_id' => $patient_id,
//    'data-toggle'=>"modal",
//    'data-target'=>"#appointment-modal"
])?>