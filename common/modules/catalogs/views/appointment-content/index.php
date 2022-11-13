<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\catalogs\models\AppointmentContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Содержание назначения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appointment-content-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'SoderzhNaz',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
