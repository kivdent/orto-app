<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pricelist Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pricelist-items-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Pricelist Items', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'pricelist_id',
            'category',
            'superior_category_id',
            //'active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
