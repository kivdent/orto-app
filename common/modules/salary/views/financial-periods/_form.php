<?php

use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\reports\models\FinancialPeriods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="financial-periods-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'nach')->widget(
                DatePicker::classname(), [
                'options' => ['placeholder' => 'Начало периода'],
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy'
                ]
            ]);
            ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'okonch')->widget(
                DatePicker::classname(), [
                'options' => ['placeholder' => 'Окончание периода'],
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy'
                ]
            ]); ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'uet')->textInput() ?>
        </div>
        <div class="col-lg-12">
            <?= $form->field($model, 'weekends')->widget(
                DatePicker::classname(), [
                'options' => ['placeholder' => 'Выходные'],
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => false,
                    'format' => 'dd.mm.yyyy',
                    'multidate' => true,
                    'multidateSeparator' => ' ; ',
                ]
            ]); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
