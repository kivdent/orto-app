<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\Appointment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="appointment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Perv')->textInput() ?>

    <?= $form->field($model, 'PatID')->textInput() ?>

    <?= $form->field($model, 'dayPR')->textInput() ?>

    <?= $form->field($model, 'NachNaz')->textInput() ?>

    <?= $form->field($model, 'OkonchNaz')->textInput() ?>

    <?= $form->field($model, 'SoderzhNaz')->textInput() ?>

    <?= $form->field($model, 'RezObzv')->textInput() ?>

    <?= $form->field($model, 'Yavka')->textInput() ?>

    <?= $form->field($model, 'NachPr')->textInput() ?>

    <?= $form->field($model, 'OkonchPr')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
