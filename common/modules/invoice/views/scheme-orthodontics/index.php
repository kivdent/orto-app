<?php

use common\modules\employee\models\Employee;
use common\modules\patient\models\Patient;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\invoice\models\SchemeOrthodonticsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Схема оплат за ортодонтию';

?>
<div class="scheme-orthodontics-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новую схему', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'pat',
            [
                'format' => 'raw',
                'attribute' => 'pat',
                'content' => function ($data) {
                    return Html::a(Patient::findOne($data->pat)->getFullName(), ['/patient/manage/view', 'patient_id' => $data->pat], ['target' => '_blank']);
                }
            ],
//            'sotr',
            [
                'format' => 'raw',
                'attribute' => 'sotr',

                'content' => function ($data) {
                    return Html::a(Employee::findOne($data->sotr)->getFullName(), ['/employee/manage/view', 'id' => $data->sotr], ['target' => '_blank']);
                }
            ],
            'date',
            'per_lech',
            'summ',
            'summ_month',
            'vnes',
            //'full',
            //'last_pay_month',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
