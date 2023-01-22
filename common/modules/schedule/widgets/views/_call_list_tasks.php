<?php

/* @var $this \yii\web\View */
/* @var $text string */
/* @var $task_id string */
/* @var $doctor_id integer */
/* @var $call_list_id string */
/* @var $patient_id integer */


use common\assets\jQueryValidationAsset;
use common\modules\patient\widgets\assets\PatientFindModalAsset;
use common\modules\schedule\widgets\assets\CallListTasksModalAsset;
use yii\helpers\Html;
//\kartik\base\WidgetAsset::register($this);
CallListTasksModalAsset::register($this);
PatientFindModalAsset::register($this);
jQueryValidationAsset::register($this)?>


<?= Html::button($text,[
    'class'=>"btn btn-success btn-task-modal-create",
    'task_id' => $task_id,
    'doctor_id' => $doctor_id,
    'patient_id' => $patient_id,
    'call_list_id'=>$call_list_id,
])?>