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

    <?= $form->field($model, 'start_date')->widget(DatePicker::class, [
            'options' => ['placeholder' => 'Дата вступления в силу'],
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy'
            ],
        ]
    ); ?>

    <?= $form->field($model, 'doctor_id')->dropDownList($model->getEmployeeList()) ?>

    <?= $form->field($model, 'appointment_duration')->dropDownList($model->getDurationIntervals()) ?>
    <?=$form->field($model, 'status')->dropDownList($model->getStatusList())?>
    <?= $this->render(['_baseSchedulesDaysForm','model'=>$model]); ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
