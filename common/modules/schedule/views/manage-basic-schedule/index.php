<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Base Schedules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-schedules-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Base Schedules', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'DateD',
            'vrachID',
            'prodpr',
            'doctor_id',
            //'created_at',
            //'updated_at',
            //'start_date',
            //'status',
            //'appointment_duration',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
