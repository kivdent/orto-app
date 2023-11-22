<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\documents\models\DocumentTemplateWord */

$this->title = 'Update Document Template Word: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Document Template Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="document-template-word-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
