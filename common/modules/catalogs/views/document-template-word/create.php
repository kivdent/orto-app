<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\documents\models\DocumentTemplateWord */

$this->title = 'Новый шаблон докмента Word';
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны докментов Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-template-word-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
