<?php
/* @var $this yii\web\View */

/* @var $scheduleManager ScheduleManager */

/* @var $days ScheduleDayManager */

use common\modules\clinic\models\Workplaces;
use common\modules\schedule\models\ScheduleDayManager;
use common\modules\schedule\models\ScheduleManager;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;


$this->title = 'Редактор расписаний за ' . $scheduleManager->month_name . '. Новый';
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
                <td>

                </td>

                <?php foreach ($row

                as $days): ?>
                <td>
                    <?php if ($scheduleManager->isAppointmentDay($days)): ?>
                        <?= date('d.m.Y', $days->date) ?>
                        <?= UserInterface::getDayWeekName(date('N', $days->date)) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',
                            ['create', 'date' => $days->date],
                            ['class' => 'btn btn-default btn-xs', 'role' => 'button']) ?>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </td>

            </tr>
            <?php foreach (Workplaces::getWorkplacesListWithShift() as $workplaceId => $workplace): ?>
                <?php for ($shift = 1; $shift <= 2; $shift++): ?>

                    <tr>
                        <td><?= $workplace . " смена " . $shift ?> </td>
                        <?php foreach ($row

                        as $days): ?>
                        <td>
                            <?php if ($scheduleManager->isAppointmentDay($days)): ?>


                                <?php foreach ($days->getForShift($workplaceId, $shift) as $appointmentDay):/**@var \common\modules\schedule\models\AppointmentsDay $appointmentDay */ ?>
                                    <?php if (!$appointmentDay->vih): ?>
                                        <?= $appointmentDay->specializationAppointmentsDayLabel; ?>
                                        <?php if ($appointmentDay->isNewRecord): ?>
                                            <?= Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
                                                ['create', 'date' => $days->date, 'doctor_id' => $appointmentDay->doctor->id],
                                                ['class' => 'btn btn-default btn-xs', 'role' => 'button']) ?>
                                        <?php else: ?>
                                            <?= $appointmentDay->hasActiveAppointments() ?
                                                Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
                                                    ['update', 'id' => $appointmentDay->id],
                                                    ['class' => 'btn btn-danger btn-xs', 'role' => 'button']) :
                                                Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
                                                    ['update', 'id' => $appointmentDay->id],
                                                    ['class' => 'btn btn-default btn-xs', 'role' => 'button']) ?>
                                        <?php endif; ?><br>
                                        <?= $appointmentDay->doctor->fullName; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                            <?php endif; ?>
                            <?php endforeach; ?>
                        </td>

                    </tr>
                <?php endfor; ?>

            <?php endforeach; ?>
            <tr>
                <td colspan="8"></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
