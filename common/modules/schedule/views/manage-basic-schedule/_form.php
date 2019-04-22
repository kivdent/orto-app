<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\BaseSchedules */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="base-schedules-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'DateD')->textInput() ?>

    <?= $form->field($model, 'vrachID')->textInput() ?>

    <?= $form->field($model, 'prodpr')->textInput() ?>

    <?= $form->field($model, 'doctor_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'appointment_duration')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
