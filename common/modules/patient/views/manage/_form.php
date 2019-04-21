<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use common\modules\userInterface\widgets\AddressFormWidget;

/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\Patient */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patient-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal',],]); ?>
    <?= $form->errorSummary($model); ?>
    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'otch')->textInput(['maxlength' => true]) ?> 
    <?= $form->field($model, 'sex')->dropDownList($model->sexList) ?>
    <?=
    $form->field($model, 'dr')->widget(
            DatePicker::classname(), [
        'options' => ['placeholder' => 'Дата рождения'],
        'removeButton' => false,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy'
        ]
    ]);
    ?>
    <?= $form->field($model, 'DTel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'RTel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MTel')->textInput(['maxlength' => true]) ?>





    <?=
    AddressFormWidget::widget([
        'form' => $form,
        'model' => $model->addressForm])
    ?>

    <?= $form->field($model, 'MestRab')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prof')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'Prim')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
