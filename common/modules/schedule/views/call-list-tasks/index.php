<?php

use common\modules\schedule\models\AppointmentsDay;
use common\modules\schedule\widgets\CallListTasksModalWidget;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $callList \common\modules\schedule\models\CallList */
/* @var $searchModel \common\modules\schedule\models\CallListTaskSearch */
$this->title = 'Список обзвона ' . $callList->title;
$this->params['breadcrumbs'][] = ['label' => 'Списки обзвона', 'url' => ['/schedule/call-list']];
$this->params['breadcrumbs'][] = $this->title;
\common\modules\schedule\assets\CallTaskAsset::register($this);
?>
<div class="call-list-tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= CallListTasksModalWidget::widget(['call_list_id' => $callList->id]) ?>
    </p>

    <?= GridView::widget([

        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table', 'width' => '100%'],
        'options' => [
            'class' => 'table-responsive',
        ],
        'rowOptions' => function ($model, $key, $index, $grid) {
            $class = $model->status == \common\modules\schedule\models\CallListTasks::TASK_STATUS_ACTIVE ? 'active' : 'warning';  // стилизация четной и нечетной строки
            return array('key' => $key, 'index' => $index, 'class' => $class);
        },
        'columns' => [
            [
                'attribute' => 'patient_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(
                        $model->patient->fullName,
                        ['/patient/appointments', 'patient_id' => $model->patient_id],
                        ['target' => '_blank']
                    );
                }
            ],
            [
                'attribute' => 'doctor_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->doctor->fullName;
                }
            ],
            'appointment_content',
            [
                'attribute' => 'result',
                'format' => 'raw',
                'value' => function ($model) {
                    $html = $model->patient->MTel . " 
                        
                        <div class=\"load\" hidden>
                                                                    <span class=\"glyphicon glyphicon-refresh\"
                                                                          aria-hidden=\"true\">
                                                                    </span>
                                                                </div>
                                                                <div class=\"notice-result\"
                                                                     call-list-task_id=\"$model->id\">
                            </div>";
                    return $html;
                }
            ],
            //'crated_at',
            //'updated_at',
            //'employee_id',
            'note',
            //'call_list_id',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{appointment} {update} {delete}',
                'buttons' => [
                    'appointment' => function ($url, $model, $key) {
                        return Html::a('',
                            ['/schedule/appointment',
                                'patient_id' => $model->patient_id,
                                'doctor_ids' => $model->doctor_id,
                                'appointment_content' => $model->appointment_content,
                                'start_date' => date('d.m.Y', AppointmentsDay::getDateWithFreeTime($model->doctor_id, date('d.m.Y'))),
                            ],
                            ['class' => 'glyphicon glyphicon-share-alt',
                                'title' => 'Назначить',
                                'target' => '_blank'
                            ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('',
                            ['/schedule/call-list-tasks/change-status',
                                'id' => $model->id,
                                'callListId' => $model->call_list_id
                            ],
                            ['class' => 'glyphicon glyphicon-trash',
                                'title' => 'Изменить статус',
                                'data' => [
                                    'confirm' => 'Изменить статус?',
                                    'method' => 'post',
                                ],
                            ]);
                    },
                ]
            ],
        ],
    ]); ?>
</div>