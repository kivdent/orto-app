<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\catalogs\models\PotentialForRateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="potential-for-rate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'rate_name') ?>

    <?= $form->field($model, 'rate_hours') ?>

    <?= $form->field($model, 'hour_price') ?>

    <?= $form->field($model, 'load_goal_percent') ?>

    <?php // echo $form->field($model, 'financial_period_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
