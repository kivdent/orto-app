<?php

use yii\helpers\Html;
use yii\web\View;


/* @var $this yii\web\View */
/* @var $model \common\modules\patient\models\MedicalRecords */
$this->title = 'Запись в медицинской карте пациента от ' . $model->getFormattedDate();
$tooth=$model->region->isTooth()? $model->getRegionName():"";
?>
<div class="raw text-center">
    <div class="col-xs-12">
        <b><?= Html::encode($this->title) ?></b>
    </div>
</div>
<div class="row small">
    <div class="col-xs-12">
        <div>
            <b>Пациент: </b><?= $model->getPatientName().' (карта №' .$model->patient_id.')' ?>
        </div>
        <div>
            <b>Врач: </b><?= $model->getEmployeName() ?>
        </div>
        <div >
            <b>Жалобы: </b><?= $tooth . " " ?><?= Html::encode($model->complaints) ?>
        </div>
        <div>
            <b>Анамнез: </b><?= $tooth . " " ?><?= Html::encode($model->anamnesis) ?>
        </div>
        <div>
            <b>Объективно: </b><?= $tooth . " " ?><?= Html::encode($model->objectively) ?>
        </div>
        <div>
            <b>Диагноз: </b><?= $tooth . " " ?><?= Html::encode($model->getDiagnosisName()) ?>
        </div>
        <div>
            <b>Лечение: </b><?= $tooth . " " ?><?= Html::encode($model->therapy) ?>
        </div>
    </div>
</div>
<div class="raw small">
    <div class="col-xs-6">
        <p>Пациент:_______________________<br><?= $model->getPatientName() ?> </p>
    </div>
    <div class="col-xs-6">
        <p>Врач:____________________________<br><?= $model->getEmployeName() ?></p>
    </div>
</div>

<script>
    window.print();
</script>