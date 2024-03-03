<?php

use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\modules\employee\models\Employee;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\patient\models\PatientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пациенты';
?>
<div class="patient-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новый пациент', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function ($model) {

                    $text = Html::a($model->id . ' <span class="label label-default">' . $model->statusName . '</span>',
                        ['/patient/manage/update', 'patient_id' => $model->id],
                        ['target' => '_blank']);

                    return $text;
                },

            ],
            'fullName',
//            'name',
//            'otch',
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
            [
                'attribute' => 'totalInvoiceSumm',
                'label'=>'Сумма по чекам'
//                'format' => 'raw',
//                'value' => function ($model) {
//                    $text = $model->addressString;
//                    return $text;
//                },
            ],
            [
                'attribute' => 'lastAppointment',
                'label'=>'Последний приём',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = UserInterface::getFormatedDate($model->lastAppointment->appointments_day->date);
                    return $text;
                },
            ],
            [
                'attribute' => 'totalAppointments',
                'label'=>'Всего приёмов',
//                'format' => 'raw',
//                'value' => function ($model) {
//                    $text = UserInterface::getFormatedDate($model->lastAppointment->appointments_day->date);
//                    return $text;
//                },
            ],

            // 'MTel',
            //  'DTel',
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
//            [
//                'attribute' => 'Prim',
//                'format' => 'raw',
//                'value' => function ($model) {
//                    $text = '';
//                    if (isset($model->duplicate)) {
//                        $text .= Html::a(
//                            'Дубликат с картой #' . $model->duplicate->id,
//                            ['/archive/manage/duplicate-delete', 'patient_id' => $model->id],
//                            ['target' => '_blank',
//                                'class' => 'btn btn-warning btn-xs']);
//                    }
//                    return $text;
//                }
//            ]
        ],
    ]);
    ?>
    <?php //Pjax::end(); ?>
</div>