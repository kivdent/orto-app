<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рабочие места';

?>
<div class="workplaces-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создание рабочего места', ['create','clinic_id'=>$clinic_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            
              [
                'attribute' =>'nazv',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a($model->nazv, Url::to(['update','id'=>$model->id,'clinic_id' => $model->clinic_id]));
                }
            ],
          
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
