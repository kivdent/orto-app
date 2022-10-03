<?php
/* @var $this \yii\web\View */
/* @var $findBtnText string */
/* @var $newPatBtnText string */
/* @var $patientIdTarget string */
/* @var $newPatBtn bool */

/* @var $patientNameTarget string */

use common\assets\jQueryValidationAsset;
use common\modules\invoice\widgets\modalTable\assets\InvoiceModalAsset;
use common\modules\patient\widgets\assets\PatientFindModalAsset;
use yii\helpers\Html;

//InvoiceModalAsset::register($this);
PatientFindModalAsset::register($this);
jQueryValidationAsset::register($this)?>
<label class="control-label" for="patient_input_group">Пациент</label>
<div class="input-group" id="patient_input_group">
    <input type="text" disabled="disabled" class="form-control" id="patient_name">
    <span class="input-group-btn">
        <?php if ($newPatBtn):?>
            <?= Html::button($newPatBtnText,
                [
                    'class' => "btn btn-primary new-patient-modal-open",
                    'patient_id_target' => $patientIdTarget,
                    'patient_name_target' => $patientNameTarget,
                    'id'=>'new_btn'
                ]); ?>
        <?php endif;?>

    <?= Html::button($findBtnText,
        [
            'class' => "btn btn-primary modal-find-patient-open",
            'patient_id_target' => $patientIdTarget,
            'patient_name_target' => $patientNameTarget,
            'id'=>'find_btn'
        ]); ?>
    </span>
</div>

<!--Modal Find Patients-->
<!--<div class="modal fade" id="find-patient-modal" tabindex="-1" role="dialog" aria-labelledby="find-patient-modal">-->
<!--    <div class="modal-dialog" role="document">-->
<!--           <div class="modal-content">\n" +-->
<!--                    <div class="modal-header">-->
<!--                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--                           <h4 class="modal-title" id="myModalLabel">Поиск пациента</h4>-->
<!--                       </div>\n" +-->
<!--                   <div class="modal-body">-->
<!---->
<!--            Поиск пациентов-->
<!--            <input class='form-control' id='modal_patient_find_input' type='text'>-->
<!--           <select class='form-control' id='modal_patient_list' size='7' >-->
<!---->
<!--                </select>-->
<!--                         -->
<!--                       </div>-->
<!--                <div class="modal-footer">-->
<!--                           <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>-->
<!--                            <button type="button" class="btn btn-primary modal-find-patient-ok">OK</button>-->
<!--                       </div>-->
<!--                </div>-->
<!--        </div>-->
<!--</div>-->
<!-- Modal Find Patients-->
