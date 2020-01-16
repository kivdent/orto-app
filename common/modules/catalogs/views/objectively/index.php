<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\catalogs\models\Objectively;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \common\modules\catalogs\models\ObjectivelySearch */

$this->title = 'Объективно';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objectively-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать шаблон "Объективно"', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'format' => 'text',
                'attribute' => 'name',
                'contentOptions' => ['style' => 'white-space: inherit;']
            ],
            [
                'format' => 'raw',
                'attribute' => 'type',
                'content' => function ($data) {
                    return $data->getTypeName();
                },
                'filter'=>Objectively::getTypeList(),
            ],
//            'text:ntext',
            [
                'format' => 'html',
                'label' => 'Форма',
                'content' => function ($data) {
                    return $data->renderForm();
                },
                'contentOptions' => ['style' => 'white-space: inherit;']

            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
