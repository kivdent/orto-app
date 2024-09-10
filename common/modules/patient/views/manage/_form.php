<?php

use common\modules\archive\models\ArchivalPatientRecords;
use common\modules\patient\models\Patient;
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
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'status')->dropDownList(Patient::getStatusNameList()) ?>
        </div>
        <div class="col-lg-4">
            <h4 style="vertical-align: bottom">
                 <?= $model->status === Patient::STATUS_ARCHIVE_IN_ARCHIVE ? 'Архивный короб:'.ArchivalPatientRecords::getArchiveBoxName($model->id) : ''; ?>
            </h4>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'type')->dropDownList(Patient::getTypesNameList()) ?>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'otch')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'sex')->dropDownList($model->sexList) ?>
        </div>
        <div class="col-lg-4">
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
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'DTel')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'RTel')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'MTel')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?php if (!$model->hasAddress()): ?>
        <div class="row">
            <div class="col col-lg-12">
                Старый адрес <?= $model->adres ?>. Внесите данные в поле ниже.
            </div>
        </div>
    <?php else: ?>
    <?php endif; ?>
    <?=
    AddressFormWidget::widget([
        'form' => $form,
        'model' => $model->addressForm])
    ?>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'MestRab')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'prof')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'Prim')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
