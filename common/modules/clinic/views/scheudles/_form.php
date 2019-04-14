<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\ClinicSheudles */
/* @var $form yii\widgets\ActiveForm */
/* composer require 2amigos/yii2-date-picker-widget:~1.0use dosamigos\datepicker\DatePicker;
 */
?>

<div class="clinic-sheudles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->radioList($model->getStatusLists()) ?>
    <?=
    $form->field($model, 'start_date')->widget(
            DatePicker::classname(), [
        'options' => ['placeholder' => 'Дата вступления в силу....'],
        'removeButton' => false,
         'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy'
        ]
    ]);
    ?>



    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
