<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\catalogs\models\PotentialForRateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Potential For Rates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="potential-for-rate-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p hidden>
        <?= Html::a('Create Potential For Rate', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <h1>В разработке</h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'rate_name',
            'rate_hours',
            'hour_price',
            'load_goal_percent',
            //'financial_period_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
