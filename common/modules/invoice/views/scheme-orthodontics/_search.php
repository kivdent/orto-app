<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\invoice\models\SchemeOrthodonticsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scheme-orthodontics-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pat') ?>

    <?= $form->field($model, 'sotr') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'per_lech') ?>

    <?php // echo $form->field($model, 'summ') ?>

    <?php // echo $form->field($model, 'summ_month') ?>

    <?php // echo $form->field($model, 'vnes') ?>

    <?php // echo $form->field($model, 'full') ?>

    <?php // echo $form->field($model, 'last_pay_month') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
