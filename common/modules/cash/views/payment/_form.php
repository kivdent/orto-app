<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\clinic\models\FinancialDivisions;
use \common\modules\cash\assets\CashAsset;

/* @var $this yii\web\View */
/* @var $payment \common\modules\cash\models\Payment */
/* @var $invoice  \common\modules\invoice\models\Invoice */
/* @var $giftCard  \common\modules\sale\models\GiftCard */

CashAsset::register($this);
?>
<h4>
    Пациент: <?= $invoice->patientFullName ?><br>
    Врач: <?= $invoice->employeeFullName ?><br>
    Сумма чека: <?= $invoice->amount_payable ?> рублей.<br>
    Остаток: <?= $invoice->amount_residual ?> рублей.
</h4>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal',],]); ?>

<?= $form->errorSummary($payment); ?>
<?php if ($invoice->type == \common\modules\invoice\models\Invoice::TYPE_GIFT_CARDS): ?>
    <?= $form->field($giftCard, 'number')->textInput() ?>
<?php endif; ?>
<?= Html::input('hidden', 'patient_id', $invoice->patient_id, ['id' => 'patient_id']) ?>
<?= $form->field($payment, 'vnes')->textInput(); ?>
<?= $form->field($payment, 'podr')->dropDownList(FinancialDivisions::getDivisionList()); ?>
<div id="payment-type-form">

</div>
<?= $form->field($payment, 'VidOpl')->dropDownList($invoice->getTypeList()); ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', [
        'class' => 'btn btn-success',
        'data' => [
            'confirm' => 'Провести оплату?',
        ],
    ]) ?>
</div>
<?php ActiveForm::end() ?>
