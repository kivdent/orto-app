<?php

use common\modules\clinic\models\Workplaces;
use common\modules\employee\models\Employee;
use common\modules\schedule\models\AppointmentsDay;
use common\modules\schedule\models\BaseSchedules;
use common\modules\schedule\models\BaseSchedulesDays;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\AppointmentsDay */
/* @var $form yii\widgets\ActiveForm */
/* @var $disabled string */

?>

<div class="appointments-day-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-4" >
                <?= $form->field($model, 'vrachID')->widget(Select2::classname(), [
                    'data' => Employee::getAllWorkedList(),
                    'options' => ['placeholder' => 'Выберите врача'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
        </div>

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
            <?= $form->field($model, 'specialization_appointments_day')->dropDownList(AppointmentsDay::getSpezializationLabels()) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 " >
            <?= $form->field($model, 'vih')->dropDownList(BaseSchedulesDays::getHolidayList()) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'rabmestoID')->dropDownList(Workplaces::getWorkplacesList()) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'comment')->textarea() ?>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-2">
            <?= $form->field($model, 'Nach')->dropDownList($model->getTimeListBeforeFirstAppointment()) ?>
        </div>

        <div class="col-lg-2">
            <?= $form->field($model, 'Okonch')->dropDownList($model->getTimeListAfterLastAppointment()) ?>
        </div>

        <div class="col-lg-2">
            <?= $form->field($model, 'TimePat')->dropDownList(BaseSchedules::getDurationIntervals()) ?>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
