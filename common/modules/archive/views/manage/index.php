<?php

use common\modules\archive\models\Archive;
use common\modules\archive\models\ArchiveBoxes;
use common\modules\archive\models\ArchivePatientSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\modules\employee\models\Employee;

/* @var $this yii\web\View */
/* @var $searchModel ArchivePatientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Карты для архивирования';
?>
<div class="patient-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>

    <h2>
        Текущий короб: <?= ArchiveBoxes::getCurrentBox() ?>
        <?= Html::a('Новый короб', ['create-archive-box'], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Вы уверены что хотите создать новый короб?',
                'method' => 'post',
            ],
        ]) ?>
    </h2>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(
                        $model->id,
                        ['/patient/manage/update', 'patient_id' => $model->id],
                        ['target' => '_blank']);
                },

            ],
//            'fullName',
            [
                'attribute' => 'fullName',
                'format' => 'raw',
                'content' => function ($model) {
                    $text=$model->fullName;
                    If (isset($model->duplicate)){
                        $text.=Html::a(
                            'Дубликат с картой #' .$model->duplicate->id,
                            ['duplicate-delete', 'patient_id' => $model->id],
                            ['target' => '_blank',
                                'class'=>'btn btn-warning btn-xs']);
                        }
                    return $text;
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{archive}',
                'buttons' => [
                    'archive' => function ($url, $model, $key) {
                        return Html::a('',
                            ['send-to-archive', 'patient_id' => $model->id],
                            ['class' => 'glyphicon glyphicon-folder-open', 'target' => '_blank']);
                    },
                ]
            ],
        ],
    ]);
    ?>
    <?php //Pjax::end(); ?>
</div>
