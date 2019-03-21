<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\employe\models\EmployeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employe-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'surname') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'otch') ?>

    <?= $form->field($model, 'dr') ?>

    <?php // echo $form->field($model, 'dtel') ?>

    <?php // echo $form->field($model, 'mtel') ?>

    <?php // echo $form->field($model, 'adres') ?>

    <?php // echo $form->field($model, 'dolzh') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
