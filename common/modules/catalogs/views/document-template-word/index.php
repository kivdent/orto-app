<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\documents\models\DocumentTemplateWordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Шаблоны докментов Words';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-template-word-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новый шаблон докмента Word', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'title',
//            'created_at',
//            'updated_at',
//            'file_name',
            'description:ntext',
            'templateVariablesString',
//            'variables',
//            [
//                'attribute' => 'variables',
//                'format' => 'raw',
//                'value' => function ($model) {
//                    return ;
//
//                }
//            ]
//            ,
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-screenshot"></span>',
                            $model->docLink,
                            ['target' => '_blank']
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
