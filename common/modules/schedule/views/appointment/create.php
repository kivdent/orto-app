<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\Appointment */
/* @var $appointment_day AppointmentsDay */

$this->title = 'Назначение пациента';

?>
<div class="appointment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'appointment_day'=>$appointment_day,
    ]) ?>

</div>
