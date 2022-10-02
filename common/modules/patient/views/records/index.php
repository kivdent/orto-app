<?php

use common\modules\employee\models\Employee;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\patient\models\Region;
use common\modules\patient\models\MedicalRecords as MedicalRecordsAlias;

/* @var $this yii\web\View */
/* @var  $medicalRecords \common\modules\patient\models\MedicalRecords */

$this->title = 'Записи';

?>
<h2>

<?=$this->title?> <?= Html::a('Новая запись', ['create', 'patient_id' =>Yii::$app->request->get('patient_id'), ], ['class' => 'btn btn-success',]) ?>
<?= Html::a('Печать', ['print-all', 'patient_id' => Yii::$app->request->get('patient_id'),  []], ['class' => 'btn btn-info', 'target' => '_blank']) ?>

</h2>

<?php foreach ($medicalRecords as $medicalRecord): ?>
    <div class="row">
        <div class="col-lg-12">
            <p>
                <?php $regionName=$medicalRecord->region->isTooth()?$medicalRecord->regionName.' ':'';
                $patient_id=$medicalRecord->patient_id;
                ?>
                <strong>Дата:</strong> <?= UserInterface::getFormatedDate($medicalRecord->created_at) ?><br/>
                <strong>Врач: </strong><?= $medicalRecord->employeName ?>

                <?php if ($medicalRecord->employe_id==Yii::$app->user->identity->employe_id or UserInterface::isUserRole(UserInterface::ROLE_ADMIN)):?>
                    <?= Html::a('Изменить', ['update', 'patient_id' => $patient_id, 'id' => $medicalRecord->id,], ['class' => 'btn btn-primary btn-xs']) ?>
                <?php endif;?>
                <?= Html::a('Печать', ['print', 'patient_id' => $patient_id, 'id' => $medicalRecord->id, []], ['class' => 'btn btn-info btn-xs', 'target' => '_blank']) ?>
               <br>
                <strong>Жалобы: </strong><?= $regionName.$medicalRecord->complaints ?><br>
                <strong>Анамнез: </strong><?= $regionName.$medicalRecord->anamnesis ?><br>
                <strong>Объективно: </strong><?=$regionName.$medicalRecord->objectively ?><br>
                <strong>Диагноз: </strong><?=$regionName.$medicalRecord->getDiagnosisName() ?><br>
                <strong>Лечение: </strong><?= $medicalRecord->regionName.' '.$medicalRecord->therapy ?><br>
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
