<?php

use common\modules\schedule\models\AppointmentsDay;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\catalogs\models\CompletedDiagnoses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="completed-diagnoses-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'speciality')->dropDownList(AppointmentsDay::getSpezializationLabels()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
