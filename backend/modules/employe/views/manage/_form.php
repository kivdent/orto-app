<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\employe\models\Employe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employe-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'otch')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dr')->textInput() ?>

    <?= $form->field($model, 'dtel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mtel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'adres')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'dolzh')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
