<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\Operation */

$this->title = 'Изменить операцию: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Операция', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="operation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
