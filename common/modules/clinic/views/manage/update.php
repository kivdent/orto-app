<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Clinics */

$this->title =$model->name;

$this->params['breadcrumbs'][] = ['label' => 'Клиника', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['update', 'id' => $model->clinic->id]];
$this->params['breadcrumbs'][] = 'Обновление данных';
?>
  <?= Html::a('Удалить', ['delete', 'id' => $model->clinic->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
<div class="clinics-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
