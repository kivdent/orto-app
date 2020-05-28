<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\salary\models\SalaryCard */

$this->title = 'Изменение зарплатной карты: ' . $model->employee->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Зарплатная карта', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="salary-card-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
