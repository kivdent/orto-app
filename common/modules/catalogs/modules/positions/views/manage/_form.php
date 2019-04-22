<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\catalogs\modules\positions\models\Positions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="positions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dolzh')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
