<?php

use common\modules\employee\models\Employee;
use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\patient\models\Region;
use common\modules\patient\models\MedicalRecords;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\patient\models\MedicalRecordsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Записи';

?>
<div class="medical-records-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <h2>
        <?= $this->title ?> <?= Html::a('Новая запись', ['create', 'patient_id' => Yii::$app->request->get('patient_id')], ['class' => 'btn btn-success']) ?>
    </h2>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'raw',
                'attribute' => 'date',

                'content' => function ($data) {
                    return Yii::$app->formatter->asDate($data->date, 'php:d.m.Y');
                }


            ],
            [
                'format' => 'raw',
                'attribute' => 'employe_id',
                'content' => function ($data) {
                    return $data->getEmployeName();
                },
                'filter' =>MedicalRecords::getDoctorListForPatient(Yii::$app->request->get('patient_id')),

            ],
            [
                'format' => 'raw',
                'attribute' => 'region_id',
                'content' => function ($data) {
                    return $data->getRegionName();
                },
                'filter' =>MedicalRecords::getRegionListForPatient(Yii::$app->request->get('patient_id')),


            ],
            [
                'format' => 'raw',
                'attribute' => 'diagnosis_id',
                'content' => function ($data) {
                    return $data->getDiagnosisName();
                }

            ],
            [
                'format' => 'text',
                'attribute' => 'objectively',
                'contentOptions' => ['style' => 'white-space: inherit;'],
                'content' => function ($data) {
                    return Html::encode(mb_substr($data->objectively,0,100));
                },
            ],
            [
                'format' => 'text',
                'attribute' => 'therapy',
                'contentOptions' => ['style' => 'white-space: inherit;'],
                'content' => function ($data) {
                    return Html::encode(mb_substr($data->therapy,0,100));
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
