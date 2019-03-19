<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\old_app\models\Usersprava */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="usersprava-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Nazv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'new_user_id')->dropDownList($model->getNewRoles()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
