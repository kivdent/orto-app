<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\employee\models\Employee;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Базовые расписания';

?>
<div class="base-schedules-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Новое базовое расписание', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            [
                'attribute' => 'doctor_id',
                'format' => 'raw',
                'value' => function ($model) {
                    $employee = Employee::findOne($model->doctor_id);

                    $name = $employee['fullName'];
                    return $name;
                }

            ],
            //'created_at',
            //'updated_at',
            'start_date:date',

            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                        return $model->status ? 'Активно': 'Не активно';
                }
            ],
            //'appointment_duration',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
