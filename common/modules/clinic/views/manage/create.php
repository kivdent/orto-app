<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\CreateForm */
/* @var $form ActiveForm */
?>
<div class="common-modules-clinic-views-manage-create">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'address') ?>
        <?= $form->field($model, 'requisites') ?>
        <?= $form->field($model, 'additional_phones') ?>
        <?= $form->field($model, 'description') ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'record_phone') ?>
        <?= $form->field($model, 'logo') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- common-modules-clinic-views-manage-create -->
