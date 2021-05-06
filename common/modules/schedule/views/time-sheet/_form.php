<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\TimePicker;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\TimeSheet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="time-sheet-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row hidden">
        <div class="col-lg-6">
            <?= $form->field($model, 'sotr')->hiddenInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'date')->hiddenInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'in')->widget(TimePicker::classname(),
                ['pluginOptions' => [
                    'showMeridian' => false,
                ]
                ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'out')->widget(TimePicker::classname(),
                ['pluginOptions' => [
                    'showMeridian' => false,
                ]
                ]) ?>
        </div>
        <div class="col-lg-4"></div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
