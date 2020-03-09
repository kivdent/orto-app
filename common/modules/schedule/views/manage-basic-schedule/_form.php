<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\forms\BaseScheduleForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="base-schedules-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="raw">
    <div class="col-lg-4">
        <?= $form->field($model, 'start_date')->widget(DatePicker::class, [
                'options' => ['placeholder' => 'Дата вступления в силу'],
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy'
                ],
            ]
        ); ?>
    </div>
    <div class="col-lg-4">
        <?= $form->field($model, 'doctor_id')->dropDownList($model->getEmployeeList()) ?>
    </div>
    <div class="col-lg-2">
        <?= $form->field($model, 'appointment_duration')->dropDownList($model->getDurationIntervals()) ?>
    </div>
    <div class="col-lg-2">
        <?= $form->field($model, 'status')->dropDownList($model->getStatusList()) ?>
    </div>
</div>






    <?php foreach ($model->scheduleDays as $scheduleDay): ?>
        <?= $this->render('_baseSchedulesDaysForm', ['model' => $scheduleDay]); ?>
    <?php endforeach; ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
