<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RejectionReasons */

$this->title = 'Создание элемента';
$this->params['breadcrumbs'][] = ['label' => 'Причины отказа', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rejection-reasons-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
