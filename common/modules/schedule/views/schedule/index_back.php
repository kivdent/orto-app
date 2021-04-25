<?php
/* @var $this yii\web\View */

/* @var $scheduleManager ScheduleManager */

/* @var $days ScheduleDayManager */

use common\modules\schedule\models\ScheduleDayManager;
use common\modules\schedule\models\ScheduleManager;
use common\modules\userInterface\models\UserInterface;

$this->title = 'Редактор расписаний за ' . $scheduleManager->month_name . '.';
?>
<h1><?= $this->title ?></h1>
<div class="manage-table">
    <table class="table table-bordered">
        <?php foreach ($scheduleManager->rows as $row): ?>
            <tr>
                <!--        <div class="row">-->
                <?php foreach ($row as $days): ?>
                    <td>
                        <?php if ($scheduleManager->isAppointmentDay($days)): ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?= date('d.m.Y', $days->date) ?></h3>
                                    <?= UserInterface::getDayWeekName(date('N', $days->date))?>
                                </div>
                                <table class="table">

                                    <?php foreach ($days->appointmentDays as $appointmentDay):/**@var \common\modules\schedule\models\AppointmentsDay $appointmentDay */ ?>
                                        <?php if (!$appointmentDay->vih): ?>
                                            <tr>
                                                <td>

                                                    <?= $appointmentDay->doctor->fullName; ?>
                                                    <?= $appointmentDay->workplace->nazv ?>
                                                    <?= $appointmentDay->Nach ?>-
                                                    <?= $appointmentDay->Okonch ?>

                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                </table>
                            </div>
                        <?php else: ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"></h3>
                                </div>
                                <div class="panel-body">

                                </div>
                            </div>
                        <?php endif; ?>
                    </td>

                <?php endforeach; ?>

            </tr>
        <?php endforeach; ?>
    </table>
</div>
