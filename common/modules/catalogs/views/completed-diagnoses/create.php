<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\catalogs\models\CompletedDiagnoses */

$this->title = 'Новая позиция';
$this->params['breadcrumbs'][] = ['label' => 'Законченные диагнозы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="completed-diagnoses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
