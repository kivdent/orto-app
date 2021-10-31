<?php
/* @var $this \yii\web\View */
/* @var $text string */
/* @var $patientIdTarget string*/
/* @var $patientNameTarget string*/

use common\modules\invoice\widgets\modalTable\assets\InvoiceModalAsset;
use common\modules\patient\widgets\assets\PatientFindModalAsset;
use yii\helpers\Html;

//InvoiceModalAsset::register($this);
PatientFindModalAsset::register($this);?>

<?=Html::button($text,
    [
        'class' => "btn btn-primary modal-find-patient-open",
          'patient_id_target'=>$patientIdTarget,
            'patient_name_target'=>$patientNameTarget,
    ]);?>