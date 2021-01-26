<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\invoice\models\SchemeOrthodontics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scheme-orthodontics-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pat')->textInput() ?>

    <?= $form->field($model, 'sotr')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'per_lech')->textInput() ?>

    <?= $form->field($model, 'summ')->textInput() ?>

    <?= $form->field($model, 'summ_month')->textInput() ?>

    <?= $form->field($model, 'vnes')->textInput() ?>

    <?= $form->field($model, 'full')->textInput() ?>

    <?= $form->field($model, 'last_pay_month')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
