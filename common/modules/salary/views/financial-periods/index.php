<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Финансовые периоды';
?>
<div class="financial-periods-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Новый финансовый период', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],
            'id',
            'nach',
            'okonch',
            'uet',
            ['class' => 'yii\grid\ActionColumn','template' => '{update}',],
        ],
    ]); ?>
</div>
