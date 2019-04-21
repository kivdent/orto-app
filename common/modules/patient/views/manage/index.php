<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\patient\models\PatientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пациенты';
?>
<div class="patient-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новый пациент', ['create'], ['class' => 'btn btn-success']) ?>
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
                    return Html::a($model->id, ['view','id'=>$model->id]);
                }
            ],
            'surname',
            'name',
            'otch',
            'dr:date',
            'MTel',
            'DTel',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}  {update}'
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
