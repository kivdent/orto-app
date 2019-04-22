<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\catalogs\modules\baseSchedulesTypes\models\BaseSchedulesTypes */

$this->title = 'Create Base Schedules Types';
$this->params['breadcrumbs'][] = ['label' => 'Base Schedules Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-schedules-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
