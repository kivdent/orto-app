<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\MedicalRecords */

$this->title = 'Запись в медицинской карте от '.$model->getFormattedDate();

\yii\web\YiiAsset::register($this);
$patient_id = Yii::$app->userInterface->params['patient_id'];
$tooth=$model->region->isTooth()? $model->getRegionName():"";
?>
<div class="medical-records-view">

    <h2><?= Html::encode($this->title) ?>

        <?= Html::a('Изменить', ['update', 'patient_id' => $patient_id, 'id' => $model->id,], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Печать', ['print', 'patient_id' => $patient_id, 'id' => $model->id, []], ['class' => 'btn btn-info', 'target' => '_blank']) ?>
        <?= Html::a('Создать', ['create', 'patient_id' => $patient_id, ], ['class' => 'btn btn-success',]) ?>
        <?= Html::a('Все записи', ['index', 'patient_id' => $patient_id, 'id' => $model->id,], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Удалить', ['delete', 'patient_id' => $patient_id, 'id' => $model->id,], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить запись?',
                'method' => 'post',
            ],
        ]) ?>
    </h2>
    <div class="row">
        <b>Врач: </b><?=$model->getEmployeName()?>
    </div>
    <div class="row">
        <b>Жалобы: </b><?=$tooth." "?><?= Html::encode($model->complaints) ?>
    </div>
    <div class="row">
        <b>Анамнез: </b><?=$tooth." "?><?= Html::encode($model->anamnesis) ?>
    </div>
    <div class="row">
        <b>Объективно: </b><?=$tooth." "?><?= Html::encode($model->objectively) ?>
    </div>
    <div class="row">
        <b>Диагноз: </b><?=$tooth." "?><?= Html::encode($model->getDiagnosisName()) ?>
    </div>
    <div class="row">
        <b>Лечение: </b><?=$tooth." "?><?= Html::encode($model->therapy) ?>
    </div>

</div>
