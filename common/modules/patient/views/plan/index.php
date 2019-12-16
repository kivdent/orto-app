<?php
$this->context->layout = '@frontend/views/layouts/light.php';
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
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
        <?= Html::a('Новый план лечения', ['create','patient_id'=>Yii::$app->request->get('patient_id')], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'created_at',
            'updated_at',
            'author',
            //'patient',
            'comments:ntext',
            //'deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
