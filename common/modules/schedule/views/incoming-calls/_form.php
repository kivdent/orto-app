<?php

use common\modules\catalogs\models\CallTarget;
use common\modules\catalogs\models\RejectionReasons;
use common\modules\employee\models\Employee;
use common\modules\schedule\models\IncomingCalls;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\IncomingCalls */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs("
 $('#call_target_list').on('change', function () {
        let text = $(('#call_target_list option:selected')).text();
        $('#incomingcalls-call_target').val($('#incomingcalls-call_target').val() + text + ' ');
    });
");
?>

<div class="incoming-calls-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-lg-6">
        <?= $form->field($model, 'doctor_id')->dropDownList([IncomingCalls::WITHOUT_DOCTOR=>'Нет']+Employee::getWorkedDoctorsList()) ?>
    </div>
    <div class="col-lg-6">
        <?= $form->field($model, 'primary_patient')->dropDownList($model->getPrimaryPatientLabelList()) ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <?= $form->field($model, 'call_target')->textarea(['rows' => 2,]) ?>
    </div>
    <div class="col-lg-6">
        <?=Html::dropDownList('call_target_list','', CallTarget::getList(),
            ['size' => 4,'class'=>'form-control','onclick'=>'"alert(\'wer\')"','id'=>'call_target_list'])?>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <?= $form->field($model, 'call_result')->radioList($model->getCallResultLabelList(),['separator' => " <br> " ]) ?>
    </div>
    <div class="col-lg-4">
        <?= $form->field($model, 'rejection_reasons_id')->radioList(RejectionReasons::getList(),['separator' => " <br> " ]) ?>

    </div>
    <div class="col-lg-4">
        <?= $form->field($model, 'by_recommendation')->radioList($model->getByRecommendationLabelList(),['separator' => " <br> " ]) ?>
    </div>
</div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
