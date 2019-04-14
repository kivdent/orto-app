<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\userInterface\widgets\AddressFormWidget;
use common\modules\userInterface\widgets\RequisitesFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Clinics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clinics-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>

    <?= AddressFormWidget::widget(['form'=>$form,'model'=>$model]); ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'record_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'additional_phones')->textarea(['rows' => 1]) ?>


    <?= RequisitesFormWidget::widget(['form'=>$form,'model'=>$model]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
