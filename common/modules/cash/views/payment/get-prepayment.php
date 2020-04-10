<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\patient\models\PatientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Авансы';
?>
<h1><?= $this->title ?></h1>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [

        [
            'attribute' => 'id',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->id, ['/patient/manage/view', 'patient_id' => $model->id], ['target' => '_blank']);
            },

        ],
        'surname',
        'name',
        'otch',
        [
            'attribute' => 'prepaymentAmount',
            'format' => 'raw',
            'label' => 'Аванс',

        ],
//        [
//            'attribute' => 'dr',
//            'format' => ['date', 'dd.MM.Y'],
//        ],
//
//        'MTel',
//        'DTel',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{pay}',
            'buttons' => [
                'pay' => function ($url, $model, $key) {
                    return Html::a('Принять аванс', ['pay-prepayment', 'patient_id' => $model->id], ['class' => 'btn btn-primary btn-xs']);

                },
            ]
        ],
    ],
]);
?>
