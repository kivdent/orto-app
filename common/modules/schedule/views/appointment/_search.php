<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\AppointmentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="appointment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Id') ?>

    <?= $form->field($model, 'Perv') ?>

    <?= $form->field($model, 'PatID') ?>

    <?= $form->field($model, 'dayPR') ?>

    <?= $form->field($model, 'NachNaz') ?>

    <?php // echo $form->field($model, 'OkonchNaz') ?>

    <?php // echo $form->field($model, 'SoderzhNaz') ?>

    <?php // echo $form->field($model, 'RezObzv') ?>

    <?php // echo $form->field($model, 'Yavka') ?>

    <?php // echo $form->field($model, 'NachPr') ?>

    <?php // echo $form->field($model, 'OkonchPr') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
