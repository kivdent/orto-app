<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\BaseSchedulesDays */
/* @var $form ActiveForm */
?>
<div class="baseSchedulesDaysForm">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'raspis_pack') ?>
        <?= $form->field($model, 'dayN') ?>
        <?= $form->field($model, 'rabmestoID') ?>
        <?= $form->field($model, 'vih') ?>
        <?= $form->field($model, 'nachPr') ?>
        <?= $form->field($model, 'okonchPr') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- _baseSchedulesDaysForm -->