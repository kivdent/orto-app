<?php
/* @var $start_date string*/
/* @var $this yii\web\View */
/* @var $appointmentManager AppointmentDayManager[] */

use common\modules\schedule\models\AppointmentDayManager;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;

$this->title='Назначение пациентов';
?>
<h3><?=$this->title?></h3>
<div class="schedule-table">
    <?php foreach ($appointmentManager as $doctorId=>$appointmentDayManager):?>
    <?php //\common\modules\userInterface\models\UserInterface::getVar($appointmentDayManager);?>
    <div class="row doctor-grid">
        <div class="col-lg-12">
            <div class="row doctor-name">
                <div class="col-lg-12">
                    <h4><?=\frontend\models\Employe::findOne($doctorId)->fullName?></h4>
                </div>
            </div>
           <div class="row">
               <?php foreach ($appointmentDayManager->appointmentsDays as $appointmentDay):?>
               <div class="col-lg-2">
                   <table class="table table-bordered">
                       <tr>
                           <td>&nbsp;</td>
                           <td><?= UserInterface::getFormatedDate($appointmentDay->date) ?></td>
                       </tr>
                       <?php if ($appointmentDay->isHoliday):?>
                           <tr>
                               <td>&nbsp;</td>
                               <td>Выходной</td>

                           </tr>
                       <?php else:?>
                       <?php foreach ($appointmentDay->grid as $time=>$row):?>
                               <tr>
                                   <td><?=date('H:i',$time)?></td>
                                   <td><?php if ($row==AppointmentDayManager::TIME_EMPTY):?>
                                       <?= Html::a('Назначить',[
                                               'create',
                                               'appointment_day_id'=>'new',
                                               'doctor_id'=>$appointmentDay->appointmentsDay->vrachID,
                                               'date'=>$appointmentDay->appointmentsDay->date,
                                               'time'=>$time
                                           ])?>
                                   <?php endif;?>
                                   </td>
                               </tr>
                       <?php endforeach;?>

                       <?php endif;?>


                   </table>
               </div>
               <?php endforeach;?>
           </div>
        </div>
    </div>

    <?php endforeach;?>
</div>