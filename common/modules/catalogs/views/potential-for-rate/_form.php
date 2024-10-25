<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\catalogs\models\PotentialForRate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="potential-for-rate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rate_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rate_hours')->textInput() ?>

    <?= $form->field($model, 'hour_price')->textInput() ?>

    <?= $form->field($model, 'load_goal_percent')->textInput() ?>

    <?= $form->field($model, 'financial_period_id')->dropDownList() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
