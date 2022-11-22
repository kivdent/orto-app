<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\documents\models\Notes;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\documents\models\NotesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Документы';

?>
<div class="notes-index">

    <h3><?= Html::encode($this->title) ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php foreach (Notes::getTypesList() as $type => $typeName): ?>
            <?= Html::a($typeName, [
                'create',
                'patient_id' => Yii::$app->userInterface->params['patient_id'],
                'type' => $type,
            ], ['class' => 'btn btn-success']) ?>
        <?php endforeach; ?>

    </h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'format' => 'raw',
                'attribute' => 'created_at',
                'content' => function ($data) {
                    return $data->createdDate;
                }
            ],
            'title',
            [
                'format' => 'raw',
                'attribute' => 'author_id',
                'content' => function ($data) {
                    return $data->authorName;
                }
            ],

            'text:ntext',
            // 'created_at',
            //'updated_at',
            //'author_id',
            //'patient_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {pdf}',
                'buttons' => [
                    'pdf' => function ($url,$data,$key) {
                        return Html::a('pdf', ['pdf', 'notes_id' => $data->id]);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
