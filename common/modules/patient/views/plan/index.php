<?php
$this->context->layout = '@frontend/views/layouts/light.php';

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\patient\models\SearchTreatmentPlan */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Планы лечения';
?>
<div class="treatment-plan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новый план лечения', ['create', 'patient_id' => Yii::$app->request->get('patient_id')], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.Y']
            ],
            [
                'attribute' => 'author',
                'format' => 'raw',
                'content' => function ($data) {
                    return $data->getAuthorName();
                },
            ],
            [
                'attribute' => 'diagnosis',
                'format' => 'raw',
                'content' => function ($data) {
                    return $data->getDiagnosisTitle();
                },
            ],
            'comments:ntext',

            ['class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(['/patient/plan/' . $action, 'id' => $model->id, 'patient_id' => Yii::$app->request->get('patient_id')]);
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
