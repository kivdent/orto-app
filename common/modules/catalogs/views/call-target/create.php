<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CallTarget */

$this->title = 'Создать элемент';
$this->params['breadcrumbs'][] = ['label' => 'Цель приёма', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="call-target-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
