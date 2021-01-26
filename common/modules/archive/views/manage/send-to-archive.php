<?php
/* @var $this yii\web\View */
/* @var $patient \common\modules\patient\models\Patient */

/* @var $archivalPatientRecord \common\modules\archive\models\ArchivalPatientRecords */

use common\models\ArchiveBoxes;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Архивирование карты';
?>
<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal',],]); ?>
<h2><?= '№' . $patient->id . ' ' . $patient->fullName ?></h2>

<div class="row">
    <div class="col-lg-4">

        <?= $form->field($archivalPatientRecord, 'archive_boxes_id')->dropDownList(ArchiveBoxes::getBoxesList()) ?>

    </div>

</div>
<div class="form-group">
    <?= Html::submitButton('Архивировать', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
