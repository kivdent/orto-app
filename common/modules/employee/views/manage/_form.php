<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use common\modules\userInterface\widgets\AddressFormWidget;

/* @var $this yii\web\View */
/* @var $model common\modules\employee\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal',],]); ?>
    
    <?= $form->errorSummary($model); ?>
    
    <?= $form->field($model, 'status')->dropDownList($model->getStatusList()) ?>
    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'otch')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'dolzh')->dropDownList($model->getPositionsList()) ?>
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
    <?= $form->field($model, 'dtel')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'mtel')->textInput(['maxlength' => true]) ?>
    <?=
    AddressFormWidget::widget([
        'form' => $form,
        'model' => $model->addressForm])
    ?>
    
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
