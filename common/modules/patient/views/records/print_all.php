<?php

use common\modules\employee\models\Employee;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\patient\models\Region;
use common\modules\patient\models\MedicalRecords;

/* @var $this yii\web\View */
/* @var  $medicalRecords MedicalRecords */

$this->title = 'Записи пациента '.\common\modules\patient\models\Patient::findOne(Yii::$app->userInterface->params['patient_id'])->fullName;

?>
<h5>
    <?=$this->title?>
</h5>

<?php foreach ($medicalRecords as $medicalRecord): ?>
    <div class="row">
        <div class="col-lg-12">
            <p class="small">
                <?php $regionName=$medicalRecord->region->isTooth()?$medicalRecord->regionName.' ':'';
                $patient_id=$medicalRecord->patient_id;
                ?>
                <strong>Дата:</strong> <?= UserInterface::getFormatedDate($medicalRecord->created_at) ?><br/>
                <strong>Врач: </strong><?= $medicalRecord->employeName ?>
                <br>
                <strong>Жалобы: </strong><?= $regionName.$medicalRecord->complaints ?><br>
                <strong>Анамнез: </strong><?= $regionName.$medicalRecord->anamnesis ?><br>
                <strong>Объективно: </strong><?=$regionName.$medicalRecord->objectively ?><br>
                <strong>Диагноз: </strong><?=$regionName.$medicalRecord->getDiagnosisName() ?><br>
                <strong>Лечение: </strong><?= $regionName.$medicalRecord->therapy ?><br>
                <?php if ($medicalRecord->recommendations): ?>
                    <strong>Рекоммендации: </strong><?=$medicalRecord->recommendations ?><br>
                <?php endif; ?>
                <?php if ($medicalRecord->prescriptions): ?>
                    <strong>Назначения: </strong><?=$medicalRecord->prescriptions ?>
                <?php endif; ?>
            </p>
        </div>
    </div>
<?php endforeach; ?>
