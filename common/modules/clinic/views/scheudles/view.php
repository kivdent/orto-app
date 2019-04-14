<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\ClinicSheudles */

$this->title = $model->name;

\yii\web\YiiAsset::register($this);
?>
<div class="clinic-sheudles-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
         <?= Html::a('Инактивировать', ['update', 'id' => $model->id,'clinic_id' => $model->clinic_id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Изменить', ['delete', 'id' => $model->id,'clinic_id' => $model->clinic_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить' . $model->name . '?',
                'method' => 'post',
            ],
        ])
        ?>
        <?= Html::a('Удалить', ['update', 'id' => $model->id,'clinic_id' => $model->clinic_id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'created_at:date',
            'updated_at:date',
            'start_date:date',
            'status',
        ],
    ])
    ?>

</div>
