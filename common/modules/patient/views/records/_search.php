<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\MedicalRecordsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medical-records-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employe_id') ?>

    <?= $form->field($model, 'region_id') ?>

    <?= $form->field($model, 'diagnosis_id') ?>

    <?= $form->field($model, 'complaints') ?>

    <?= $form->field($model, 'anamnesis') ?>

    <?php // echo $form->field($model, 'objectively') ?>

    <?php // echo $form->field($model, 'recommendations') ?>

    <?php // echo $form->field($model, 'prescriptions') ?>

    <?php // echo $form->field($model, 'invoice_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
