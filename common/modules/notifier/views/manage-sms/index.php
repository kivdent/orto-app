<?php

use common\modules\notifier\models\Sms;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отправленные смс';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sms-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'created_at:dateTime',
            [
                'attribute' => 'created_at',
                'value' => function ($data) {
                    return UserInterface::getFormatedDateTime($data->created_at);
                }
            ],
//            'updated_at',
            //  'patient_id',
            [
                'attribute' => 'patient_id',
                'value' => function ($data) {
                    return $data->patient->fullName;
                }
            ],
            'phone',
            //'sms_id',
//            'status',
            [
                    'attribute' => 'status',
                'value' => function($data){
        return Sms::getStatusList()[$data->status];
                }
            ],
//            'type',
            [
                'attribute' => 'type',
                'value' => function ($data) {
                    return Sms::getTypeList()[$data->type];
                }
            ],
            'text:ntext',
//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
