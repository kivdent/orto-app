<?php

use common\modules\documents\models\DocumentTemplateWord;
use common\modules\documents\widgets\WordTemplateWidgetChooser;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\documents\models\Notes;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\documents\models\NotesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Документы';

?>
<div class="notes-index">
    <h3><?= Html::encode($this->title) ?></h3>
    <div class="row">
        <!-- Базовый-->
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-3"><h5>Базовые документы </h5></div>
                <div class="col-lg-9"><?= WordTemplateWidgetChooser::widget(['patient_id' => Yii::$app->userInterface->params['patient_id']]) ?></div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?php foreach (DocumentTemplateWord::getPatFiles(Yii::$app->userInterface->params['patient_id']) as $patFileLink): ?>
                        <p><?= $patFileLink ?></p>
                    <?php endforeach ?>

                </div>
            </div>
        </div>
        <!-- Дополнительный-->
        <div class="col-lg-6">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <div class="row">
                <div class="col-lg-3"><h5>Дополнительные документы </h5></div>
                <div class="col-lg-9">
                    <?php foreach (Notes::getTypesList() as $type => $typeName): ?>
                        <?= Html::a($typeName, [
                            'create',
                            'patient_id' => Yii::$app->userInterface->params['patient_id'],
                            'type' => $type,
                        ], ['class' => 'btn btn-success']) ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
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
                                    'pdf' => function ($url, $data, $key) {
                                        return Html::a('pdf', ['pdf', 'notes_id' => $data->id]);
                                    }
                                ]
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>


</div>
