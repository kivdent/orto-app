<?php

use common\modules\clinic\models\Workplaces;
use common\modules\schedule\models\BaseSchedules;
use common\modules\schedule\models\BaseSchedulesDays;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\BaseSchedulesDays */
/* @var $form ActiveForm */
/* @var $i integer*/
$weekDay = Yii::$app->userInterface->getNameDayWeek($model->dayN);
?>

<h4><?= $weekDay ?></h4>

<div class="row baseSchedulesDaysForm">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, "[$i]rabmestoID")->dropDownList(Workplaces::getWorkplacesList()) ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, "[$i]vih")->dropDownList(BaseSchedulesDays::getHolidayList()) ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, "[$i]nachPr")->dropDownList(BaseSchedules::getTimeList()) ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, "[$i]okonchPr")->dropDownList(BaseSchedules::getTimeList()) ?>
            </div>
        </div>
    </div>
</div>
<!-- _baseSchedulesDaysForm -->
