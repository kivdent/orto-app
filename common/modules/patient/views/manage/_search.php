<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\PatientSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patient-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php echo$form->field($model, 'id') ?>

    <?php echo$form->field($model, 'surname') ?>

    <?php //echo$form->field($model, 'name') ?>

    <?php //echo$form->field($model, 'otch') ?>

    <?php //$form->field($model, 'dr') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'adres') ?>

    <?php // echo $form->field($model, 'MestRab') ?>

    <?php // echo $form->field($model, 'prof') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'DTel') ?>

    <?php // echo $form->field($model, 'RTel') ?>

    <?php // echo $form->field($model, 'MTel') ?>

    <?php // echo $form->field($model, 'FLech') ?>

    <?php // echo $form->field($model, 'Skidka') ?>

    <?php // echo $form->field($model, 'Prim') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
