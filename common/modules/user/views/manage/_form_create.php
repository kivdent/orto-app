<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\employe\models\Employe;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\CreateUserForm */
/* @var $form yii\widgets\ActiveForm */
/*@var $roles array*/

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->input('text')?>

    <?= $form->field($model, 'email')->input('text')?>
    <?= $form->field($model, 'password')->passwordInput() ?>
   <?= $form->field($model, 'employe_id')->dropDownList(Employe::getList())?>
    <?=$form->field($model, 'roles')->dropDownList($roles)?>

     <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
