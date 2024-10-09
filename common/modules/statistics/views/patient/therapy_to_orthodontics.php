<?php
/* @var $this yii\web\View */
/* @var $patientStatistics PatientStatistics */

use common\modules\statistics\models\PatientStatistics;
use common\modules\userInterface\models\UserInterface;
$this->title='Количество пациентов направленных терапевтами на ортодонтию';

?>

<h1>
    Статистика по пациентам
</h1>
<table class="table table-bordered">
    <tr>
        <td>Пациент</td>
        <td>Первый приём терапия</td>
        <td>Первая работа ортодонта</td>
        <td>Консультация ортодонта</td>
        <td>Направлен к ортодонту</td>
    </tr>
    <?php foreach ($patientStatistics->getTherapyConsultationFirstDate() as $invoice):?>
        <tr>
            <td>
                <a href="http://orto-app.local/patient/invoices?patient_id=<?=$invoice->patient_id?>" target="_blank">
                    <?=$invoice->patientFullName?>
                </a>
            </td>
            <td><?=$invoice->created_at?></td>
            <td><?=$invoice->patient->getOrthodonticsFirstDateForPatient()?></td>
            <td><?=$invoice->patient->getFirstOrthodonticsConsultation()?></td>
            <td><?=PatientStatistics::EarlyTherapy($invoice)?'Терапия ранее':''?></td>
        </tr>
    <?php endforeach;?>

</table>