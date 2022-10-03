<?php

use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $appointment common\modules\schedule\models\Appointment */
/* @var $appointment_day common\modules\schedule\models\AppointmentsDay */

$this->title = 'Изменить назначение';

?>
<div class="appointment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <h4>Дата: <?= Html::encode(UserInterface::getFormatedDate($appointment_day->date)) ?></h4>
    <h4>Врач: <?= Html::encode($appointment_day->doctor->fullName) ?></h4>
    <h4>Пациент: <?= Html::encode($appointment->patient->fullName) ?></h4>
    <?= $this->render('_form_update', [
        'model' => $appointment,
        'appointment_day'=>$appointment_day
    ]) ?>

</div>
