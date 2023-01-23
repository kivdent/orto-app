<?php

use common\modules\schedule\models\CallList;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\CallList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="call-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Description')->textarea() ?>


    <?= $form->field($model, 'type')->dropDownList(CallList::getTypeList()) ?>

    <?= $form->field($model, 'status')->dropDownList(CallList::getStatusList()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
