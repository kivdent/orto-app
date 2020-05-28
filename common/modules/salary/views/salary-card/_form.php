<?php

use common\modules\employee\models\Employee;
use common\modules\salary\models\PercentageScheme;
use common\modules\salary\models\SalaryCardType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\salary\models\SalaryCard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="salary-card-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sotr')->dropDownList(Employee::getList()) ?>

    <?= $form->field($model, 'type')->dropDownList(SalaryCardType::getTypeList()) ?>

    <?= $form->field($model, 'stavka')->textInput() ?>

    <?= $form->field($model, 'ps')->dropDownList(PercentageScheme::getTypeList())?>

    <?= $form->field($model, 'ph')->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
