<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clinics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clinics-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Clinics', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'address',
            'phone',
            'record_phone',
            //'additional_phones:ntext',
            //'description:ntext',
            //'logo',
            //'requisites',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
