<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\MedicalRecords */

$this->title = 'Изменение записи в медицинской карте от ' . Yii::$app->formatter->asDate($model->date,'php:d.m.Y');

?>
<div class="medical-records-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
