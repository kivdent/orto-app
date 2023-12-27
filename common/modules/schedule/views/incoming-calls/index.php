<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\schedule\models\IncomingCallsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Регистрация входящих звонков';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoming-calls-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute' => 'created_at',
                'format' => ['datetime', 'php:d.m.Y H:i']
            ],
            [
                'attribute' => 'doctor_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return ($model->doctor_id == 0) ? NULL : $model->doctor->fullName;
                }
            ],
//            'updated_at',

            [
                'attribute' => 'employee_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->employee->fullName;
                }

            ],
            [
                'attribute' => 'primary_patient',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getPrimaryPatientLabelList()[$model->primary_patient];
                }
            ],
            'call_target:ntext',
            [
                'attribute' => 'call_result',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getCallResultLabelList()[$model->call_result];
                }
            ],
            [
                'attribute' => 'by_recommendation',
                'format' => 'raw',
                'value' => function ($model) {
                    //return $model->getByRecommendationLabelList()[$model->by_recommendation];
                    return $model->getByRecommendation();
                }
            ],
            [
                'attribute' => 'rejection_reasons_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->rejectionReasons->title;
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>