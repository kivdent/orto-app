<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\images\models\ImagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фотографии';

?>
<div class="images-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Загрузить фотографию', ['create', 'patient_id' => Yii::$app->userInterface->params['patient_id'],], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'format' => 'raw',
                'attribute' => 'created_at',
                'content' => function ($data) {
                    return Yii::$app->formatter->asDate($data->created_at,'php:d.m.Y').'<br>'.Html::encode($data->authorName);
                }
            ],
            [
                'format' => 'raw',
                'attribute' => 'description',
                'content' => function ($data) {
                    return Html::encode($data->description);
                }
],
            [
                'format' => 'html',
                'attribute' => 'file_name',
                'label' => 'Фотография',
                'content' => function ($data) {
                    return Html::img($data->getImageLink(),[
                            'class'=>'img-responsive'
                    ]);
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
