<?php
/* @var $this yii\web\View */

/* @var $scheduleManager ScheduleManager */

/* @var $days ScheduleDayManager */

use common\modules\schedule\models\ScheduleDayManager;
use common\modules\schedule\models\ScheduleManager;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;


$this->title = 'Редактор расписаний за ' . $scheduleManager->month_name . '.';
?>
<h1><?= $this->title ?></h1>
<div class="manage-table">
    <div class="row">
        <div class="col-lg-12">
            <h3><?= Html::a(
                    UserInterface::getMonthName(date('n', strtotime(date('d.m.Y', $scheduleManager->start_date) . '-1 month'))),
                    ['index', 'start_date' => date('01.m.Y', strtotime(date('d.m.Y', $scheduleManager->start_date) . '-1 month'))]
                ) ?>|
                <?= Html::a(
                    UserInterface::getMonthName(date('n', strtotime(date('d.m.Y', $scheduleManager->start_date) . '+1 month'))),
                    ['index', 'start_date' => date('01.m.Y', strtotime(date('d.m.Y', $scheduleManager->start_date) . '+1 month'))]
                ) ?></h3>

        </div>
    </div>
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
                                    <?= UserInterface::getDayWeekName(date('N', $days->date)) ?>
                                    <a class="btn btn-default btn-xs" href="create?date=<?= $days->date ?>"
                                       role="button"><span
                                                class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>

                                </div>
                                <table class="table">

                                    <?php foreach ($days->appointmentDays as $appointmentDay):/**@var \common\modules\schedule\models\AppointmentsDay $appointmentDay */ ?>
                                        <?php if (!$appointmentDay->vih): ?>
                                            <tr>
                                                <td>
                                                    <?= $appointmentDay->workplace->nazv ?>
                                                    <?php if ($appointmentDay->isNewRecord): ?>
                                                        <a class="btn btn-default btn-xs"
                                                           href="create?date=<?= $days->date ?>&doctor_id=<?= $appointmentDay->doctor->id ?>"
                                                           role="button"><span
                                                                    class="glyphicon glyphicon-pencil"
                                                                    aria-hidden="true"></span></a>
                                                    <?php else: ?>
                                                        <a class="btn btn-default btn-xs"
                                                           href="update?id=<?= $appointmentDay->id ?>"
                                                           role="button"><span class="glyphicon glyphicon-pencil"
                                                                               aria-hidden="true"></span></a>

                                                    <?php endif; ?>
                                                    <?= $appointmentDay->doctor->fullName; ?>
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
