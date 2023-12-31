<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\salary\models\SalaryCard */

$this->title = 'Create Salary Card';
$this->params['breadcrumbs'][] = ['label' => 'Salary Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salary-card-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
