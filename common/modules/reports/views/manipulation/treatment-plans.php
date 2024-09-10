<?php

use common\modules\reports\widgets\financialPeriodChooseWidget\FinancialPeriodChooseWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\modules\employee\models\Employee;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\reports\models\PatientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $patientWOTreatmentPlans int*/
/* @var $patientsCount int */

$this->title = 'Пациенты';
?>
<div class="patient-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= FinancialPeriodChooseWidget::widget(['link' => '/reports/manipulation/treatment-plans','var' => 'financialPeriodId',])?><br>
<p>Всего пациентов с оплатами: <?=$patientsCount?></p>
<p>Всего пациентов без плана лечения: <?=$patientWOTreatmentPlans?></p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = Html::a($model->id . ' <span class="label label-default">' . $model->statusName . '</span>', ['/patient/manage/update', 'patient_id' => $model->id], ['target' => '_blank']);

                    return $text;
                },

            ],
            'fullName',

            [
                'attribute'=>'treatmentPlansCount',
                'label'=>'Количество планов лечения',
                'filter'=>array("0"=>"0","1"=>"1","2"=>"2","3"=>"3","4"=>"4",),
            ],
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
            ]
        ],
    ]);
    ?>
    <?php //Pjax::end(); ?>
</div>
