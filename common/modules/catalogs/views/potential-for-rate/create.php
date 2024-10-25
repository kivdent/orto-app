<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\catalogs\models\PotentialForRate */

$this->title = 'Create Potential For Rate';
$this->params['breadcrumbs'][] = ['label' => 'Potential For Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="potential-for-rate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
