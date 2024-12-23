<?php
/* @var $this yii\web\View */
/* @var $patientStatistics PatientStatistics */

use common\modules\statistics\models\PatientStatistics;
use common\modules\userInterface\models\UserInterface;
$this->title='Пациенты с эндо прошедшие ортопедию';

?>

<h1>
    Статистика по пациентам
</h1>
<table class="table table-bordered">
    <tr>
        <td>Пациент</td>
        <td>Эндодонтия дата</td>
        <td>Коронка дата</td>
    </tr>
    <?php foreach ($patientStatistics->getEndoCases() as $endoCaseInvoice):?>
        <tr>
            <td>
                <a href="http://orto-app.local/patient/invoices?patient_id=<?=$endoCaseInvoice->patient_id?>" target="_blank">
                    <?=$endoCaseInvoice->patientFullName?>
                </a>
            </td>
            <td><?=$endoCaseInvoice->date?></td>
            <td><?=$endoCaseInvoice->patient->lastDateManipulationInvoice(PatientStatistics::ORTHOPEDIC_CROWN_IDS)?->created_at?></td>
        </tr>
    <?php endforeach;?>

</table>