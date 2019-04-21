<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\Clinics */

$this->title =$model->name;

?>

 
<div class="clinics-update">

    <h1><?= Html::encode($this->title) ?> <?= Html::a('Удалить', ['delete', 'clinic_id' => $model->clinic->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить клинику?',
                'method' => 'post',
            ],
        ]) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
