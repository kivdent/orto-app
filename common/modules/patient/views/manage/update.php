<?php

use yii\helpers\Html;

$this->context->layout = '@frontend/views/layouts/light.php';
/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\Patient */

$this->title = 'Изменение данных пациента карта №' . $model->id . ' ' . $model->fullName;
?>
<div class="patient-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>