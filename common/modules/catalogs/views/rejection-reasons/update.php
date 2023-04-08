<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RejectionReasons */

$this->title = 'Изменениеи причины отказа: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Причины отказа', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="rejection-reasons-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
