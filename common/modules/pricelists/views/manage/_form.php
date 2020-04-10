<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\pricelists\models\Pricelist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pricelist-form">
    <?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-lg-6">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-lg-3">
        <?= $form->field($model, 'active')->dropDownList($model->getStatusList()) ?>
    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'type')->dropDownList($model->getTypeList()) ?>
    </div>

</div>
<div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
