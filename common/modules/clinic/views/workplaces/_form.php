<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\Workplaces */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="workplaces-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nazv')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
