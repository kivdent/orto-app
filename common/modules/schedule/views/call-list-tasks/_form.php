<?php

use common\modules\employee\models\Employee;
use common\modules\patient\widgets\PatientFindModalWidget;
use common\modules\schedule\models\AppointmentContent;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\CallListTasks */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs("
$('#appointment-content-list').on('select2:select', function (e) {
    var text = e.params.data.text;

    $('#calllisttasks-appointment_content').val($('#calllisttasks-appointment_content').val()+text+' ');
});
"
);
?>

<div class="call-list-tasks-form">

    <?php $form = ActiveForm::begin(); ?>
    <div hidden><?= $form->field($model, 'patient_id')->textInput() ?></div>
    <div class="row">
        <div class="col-lg-6">
            <?= PatientFindModalWidget::widget([
                'patientIdTarget' => '#calllisttasks-patient_id'
            ]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'doctor_id')->dropDownList(Employee::getDoctorsList()) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'appointment_content')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-lg-6">
            <?= Select2::widget([
                'id' => 'appointment-content-list',
                'name' => 'appointment-content-list',
                'data' => AppointmentContent::getContentList(),
                'options' => ['placeholder' => 'Выбрать ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
    </div>
    <div hidden>
        <?= $form->field($model, 'result')->textInput(['maxlength' => true]) ?>
    </div>


    <?= $form->field($model, 'note')->textarea() ?>
    <div hidden>
        <?= $form->field($model, 'call_list_id')->textInput(['maxlength' => true]) ?>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
