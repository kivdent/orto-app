<?php

use common\modules\schedule\models\CallList;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \common\modules\schedule\models\CallListSearch */


$this->title = 'Списки обзвона';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="call-list-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Новый список обзвона', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'title',
            'Description',

            [
                'attribute' => 'created_at',
                'format' => ['date', 'dd.MM.Y'],
            ],
            //'updated_at',
            //'employee_id',
            [
                'attribute' => 'employee_id',
                'format' => 'raw',
                'filter' => \common\modules\employee\models\Employee::getList(),
                'value' => function ($model) {
                    $text = $model->employee->fullName;
                    return $text;
                },
            ],
            // 'type',
//             'status',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => CallList::getStatusList(),
                'value' => function ($model) {
                    return CallList::getStatusList()[$model->status];
                }
            ],


            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [

                    'view' => function ($url, $model, $key) {
                        return Html::a('',
                            ['/schedule/call-list-tasks', 'callListId' => $model->id],
                            ['class' => 'glyphicon glyphicon-eye-open', ]);

                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('',
                            ['/schedule/call-list/change-status', 'id' => $model->id],
                            ['class' => 'glyphicon glyphicon-trash',
                                'data' => [
                                    'confirm' => 'Изменить статус?',
                                    'method' => 'post',
                                ],
                            ]);

                    },

                ]
            ],
//            ['class' => 'yii\grid\ActionColumn',
//                'template' => '{view update delete}',
//                'buttons' => [
//                    'update' => function ($url, $model, $key) {
//                        return Html::a('',
//                            ['/patient/manage/update', 'patient_id' => $model->id],
//                            ['class' => 'glyphicon glyphicon-pencil', 'target' => '_blank']);
//
//                    },
//                    'view' => function ($url, $model, $key) {
//                        return Html::a('',
//                            ['/patient/manage/update', 'patient_id' => $model->id],
//                            ['class' => 'glyphicon glyphicon-pencil', 'target' => '_blank']);
//
//                    },
//                    'delete' => function ($url, $model, $key) {
//                        return Html::a('',
//                            ['/patient/manage/update', 'patient_id' => $model->id],
//                            ['class' => 'glyphicon glyphicon-pencil', 'target' => '_blank']);
//
//                    },
//                ]
//            ],
        ],
        'rowOptions' => function ($model, $key, $index, $grid) {
            $class = $model->status == CallList::STATUS_ACTIVE ? 'active' : 'warning';  // стилизация четной и нечетной строки
            return array('key' => $key, 'index' => $index, 'class' => $class);
        },
    ]); ?>
</div>
