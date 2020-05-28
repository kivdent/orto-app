<?php

use common\modules\salary\models\PercentageScheme;
use common\modules\salary\models\SalaryCardType;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Зарплатные карты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salary-card-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//
//            'id',
//            'sotr',
            [
                'attribute' => 'sotr',
                'value' => function ($model) {
                    return $model->employee->fullName;
                }
            ],

            [
                'attribute' => 'type',
                'value' => function ($model) {
                    return SalaryCardType::getTypeList()[$model->type];
                }
            ],
//            'stavka',

//            [
//                'attribute' => 'ps',
//                'value' => function ($model) {
//                    return isset(PercentageScheme::getTypeList()[$model->ps])?PercentageScheme::getTypeList()[$model->ps]:'Не установлена';
//                }
//
//            ],
            //'ph',
            //'pn',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],

        ],
    ]); ?>
</div>
