<?php

use common\modules\schedule\models\AppointmentsDay;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\Appointment */
/* @var $appointment_day AppointmentsDay */

$this->title = 'Назначение пациента';

?>
<div class="appointment-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <h4>Врач:<?= Html::encode($appointment_day->doctor->fullName) ?></h4>
    <h4>Дата:<?= Html::encode(UserInterface::getFormatedDate($appointment_day->date)) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
        'appointment_day'=>$appointment_day,
    ]) ?>

</div>
