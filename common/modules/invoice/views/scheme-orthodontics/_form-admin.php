<?php

use common\modules\employee\models\Employee;
use common\modules\invoice\widgets\form\InvoiceFormWidget;
use common\modules\patient\models\Patient;
use common\modules\userInterface\models\UserInterface;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\jui\DatePicker as DatePickerYii;
use yii\widgets\ActiveForm;
use common\modules\pricelists\models\Pricelist;

/* @var $this yii\web\View */
/* @var $model common\modules\invoice\models\SchemeOrthodontics */
/* @var $form yii\widgets\ActiveForm */
$monthCount = [];
for ($i = 1; $i <= 36; $i++) {
    $monthCount[$i] = $i;
}
$this->registerJs("
function changeSummMonth(){
let period=$('#per_lech').val();
let summ=$('#summ').val();
let summ_month=0;
summ_month=Math.floor(summ/period/100)*100;
$('#summ_month').val(summ_month);
}
$('#per_lech').on('change',function(){
changeSummMonth();
});

$('#summ').on('keyup',function(){
changeSummMonth();
});
$('#invoice_form').on('hidden.bs.modal', function (e) {
  changeSummMonth();
})
");
?>
<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-lg-6">
        <?= $form->field($model, 'sotr')->dropDownList(Employee::getDoctorsList()) ?>
    </div>
    <div class="col-lg-6">
        <div hidden><?= $form->field($model, 'pat')->hiddenInput(['id' => 'patId']) ?></div>
        <?= \common\modules\patient\widgets\PatientFindModalWidget::widget([
            'newPatBtn' => false,
            'patientIdTarget' => '#patId',
        ]) ?>
    </div>
</div>


<div class="row">
    <div class="col-lg-3">
        <div class="scheme-orthodontics-form">

            <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Дата создания'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);?>

            <?= $form->field($model, 'summ')->textInput(['class' => 'summ form-control', 'id' => 'summ'])->label('Стоимость' . Html::button('<span class="glyphicon glyphicon-th" aria-hidden="true"></span>', [
                    'class' => 'btn btn-primary btn-xs',
                    'data-toggle' => "modal",
                    'data-target' => "#invoice_form",
                    'data-recipient' => "find",
                    'data-recipient-item-class' => ".summ",
                ])); ?>

            <?= InvoiceFormWidget::widget([
                'type' => InvoiceFormWidget::TYPE_MODAL_CALCULATOR,
                'typePriceList' => [Pricelist::TYPE_MANIPULATIONS, Pricelist::TYPE_MATERIALS],
            ]) ?>
            <?= $form->field($model, 'per_lech')->dropDownList($monthCount, ['id' => 'per_lech']) ?>



            <?= $form->field($model, 'summ_month')->textInput(['id' => 'summ_month']) ?>

            <?= $form->field($model, 'vnes')->textInput(['id' => 'vnes']) ?>


            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
    <div class="col-lg-9">

    </div>
</div>

