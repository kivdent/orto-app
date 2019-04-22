<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\catalogs\modules\baseSchedulesTypes\models\BaseSchedulesTypes */

$this->title = 'Update Base Schedules Types: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Base Schedules Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="base-schedules-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
