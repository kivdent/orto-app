<?php
/* @var $start_date string*/
/* @var $this yii\web\View */
/* @var $appointmentsDays AppointmentDayManager[] */

use common\modules\schedule\models\AppointmentDayManager;

$this->title='Назначение пациентов';
?>
<h3><?=$this->title?></h3>
<div class="schedule-table">
    <?php foreach ($appointmentsDays as $appointmentsDay):?>
    <?php endforeach;?>
</div>