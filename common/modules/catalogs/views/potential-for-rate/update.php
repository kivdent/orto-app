<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\catalogs\models\PotentialForRate */

$this->title = 'Update Potential For Rate: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Potential For Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="potential-for-rate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
