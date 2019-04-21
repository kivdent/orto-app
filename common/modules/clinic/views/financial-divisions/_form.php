<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\userInterface\widgets\RequisitesFormWidget;
/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\FinancialDivisions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="financial-divisions-form">

    <?php $form = ActiveForm::begin(); ?>

 

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= RequisitesFormWidget::widget(['form'=>$form,'model'=>$model->requisites]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
