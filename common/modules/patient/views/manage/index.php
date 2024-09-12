<?php

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
            'MTel',
            'DTel',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('',
                            ['/patient/manage/update', 'patient_id' => $model->id],
                            ['class' => 'glyphicon glyphicon-pencil', 'target' => '_blank']);

                    },
                ]
            ],
            [
                'attribute' => 'Prim',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = '';
                    if (isset($model->duplicate)) {
                        $text .= Html::a(
                            'Дубликат с картой #' . $model->duplicate->id,
                            ['/archive/manage/duplicate-delete', 'patient_id' => $model->id],
                            ['target' => '_blank',
                                'class' => 'btn btn-warning btn-xs']);
                    }
                    return $text;
                }
            ],[ 'attribute' => 'card_type',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = \common\modules\patient\models\Patient::getTypesNameList()[$model->type];

                    return $text;
                }]

        ],
    ]);
    ?>
    <?php //Pjax::end(); ?>
</div>
