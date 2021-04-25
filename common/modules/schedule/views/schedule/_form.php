<?php

use common\modules\clinic\models\Workplaces;
use common\modules\employee\models\Employee;
use common\modules\schedule\models\BaseSchedules;
use common\modules\schedule\models\BaseSchedulesDays;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\AppointmentsDay */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="appointments-day-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'date')->widget(
                DatePicker::classname(), [
                'options' => ['placeholder' => 'дата'],
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy'
                ]
            ]); ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'vih')->dropDownList(BaseSchedulesDays::getHolidayList()) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'rabmestoID')->dropDownList(Workplaces::getWorkplacesList()) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'vrachID')->dropDownList(Employee::getDoctorsList()) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'Nach')->dropDownList(BaseSchedules::getTimeList()) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'Okonch')->dropDownList(BaseSchedules::getTimeList()) ?>
        </div>

        <div class="col-lg-2">
            <?= $form->field($model, 'TimePat')->dropDownList(BaseSchedules::getDurationIntervals()) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <div class="row"></div>

    </div>
