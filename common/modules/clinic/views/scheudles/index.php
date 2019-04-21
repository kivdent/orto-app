<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Расписание работы';
?>
<div class="clinic-sheudles-index">

    <h1><?= Html::encode($this->title) ?> <?= Html::a('Создать', ['create', 'clinic_id' => $clinic_id], ['class' => 'btn btn-success']) ?></h1>





    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' =>'name',
                'format' => 'raw',
                'value' => function($model,$clinic_id) {
                    return Html::a($model->name, Url::to(['update','id'=>$model->id,'clinic_id' => $model->clinic_id]));
                }
            ],
            'created_at:date',
            'updated_at:date',
            'start_date:date',
            
             [
                'attribute' =>'status',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->statusLists[$model->status];
                }
            ],
            
        ],
    ]);
    ?>
</div>
