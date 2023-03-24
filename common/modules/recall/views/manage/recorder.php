<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\modules\employee\models\Employee;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\patient\models\PatientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дни рождения пациентов';
?>
<div class="patient-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = Html::a($model->id . ' <span class="label label-default">' . $model->statusName . '</span>', ['update', 'patient_id' => $model->id], ['target' => '_blank']);

                    return $text;
                },

            ],
            'surname',
            'name',
            'otch',
            [
                'attribute' => 'dr',
                'format' => ['date', 'dd.MM.Y'],
            ],
            [
                'attribute' => 'address_id',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = $model->addressString;
                    return $text;
                },
            ],
//            [
//                'class' => 'yii\grid\ActionColumn',
//                'template' => '{update}',
//                'buttons' => [
//                    'update' => function ($url, $model, $key) {
//                        return Html::a('',
//                            ['/patient/manage/update', 'patient_id' => $model->id],
//                            ['class' => 'glyphicon glyphicon-pencil', 'target' => '_blank']);
//
//                    },
//                ]
//            ],
            [
                'attribute' => 'Prim',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = 'Последнее посещение: '.$model->lastAppointment->appointments_day->date.'<br>';
                    $text.='Всего посещений: '.$model->totalAppointments.'<br>';
                    $text.='Сумма за лечение: '.$model->totalInvoiceSumm;

                    return $text;
                }
            ]
        ],
    ]);
    ?>
    <?php //Pjax::end(); ?>
</div>
