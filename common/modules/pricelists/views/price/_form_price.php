<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelPricelistItems common\modules\pricelists\models\PricelistItems */
/* @var  $modelPrices \common\modules\pricelists\models\Prices*/
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pricelist-items-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelPricelistItems, 'title')->textInput(['maxlength' => true]) ?>


    <?= $form->field($modelPricelistItems, 'active')->dropDownList($modelPricelistItems->getStatusList()) ?>
    <?=$form->field($modelPrices, 'price')->textInput(['maxlength' => true])?>
    <?=$form->field($modelPrices, 'coefficient')->textInput(['maxlength' => true])?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
