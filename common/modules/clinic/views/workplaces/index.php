<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\clinic\widgets\ClinicManageMenuWidget;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рабочие места';

?>
<div class="workplaces-index">
    <?= ClinicManageMenuWidget::widget(['clinic_id'=> $clinic_id]);?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создание рабочего места', ['create','clinic_id'=>$clinic_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            'nazv',
          
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
