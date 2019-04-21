<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\Patient */

$this->title = 'Изменение данных пациента карта №'.$model->id.' '.$model->fullName;

?>
<div class="patient-update">

    <h3>Карта № <?= Html::encode($model->id) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
