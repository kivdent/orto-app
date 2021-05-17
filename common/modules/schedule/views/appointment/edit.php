<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\schedule\models\AppointmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Appointments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appointment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Appointment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Id',
            'Perv',
            'PatID',
            'dayPR',
            'NachNaz',
            //'OkonchNaz',
            //'SoderzhNaz',
            //'RezObzv',
            //'Yavka',
            //'NachPr',
            //'OkonchPr',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
