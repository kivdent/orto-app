<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\CallList */

$this->title = 'Изменить список обзвона: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Списки обзвона', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['/schedule/call-list-tasks', 'callListId' => $model->id]];

?>
<div class="call-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
