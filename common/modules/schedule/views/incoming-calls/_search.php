<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\IncomingCallsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="incoming-calls-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'doctor_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'updated_at') ?>

    <?= $form->field($model, 'employee_id') ?>

    <?php // echo $form->field($model, 'primary_patient') ?>

    <?php // echo $form->field($model, 'call_target') ?>

    <?php // echo $form->field($model, 'call_result') ?>

    <?php // echo $form->field($model, 'by_recommendation') ?>

    <?php // echo $form->field($model, 'rejection_reasons_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
