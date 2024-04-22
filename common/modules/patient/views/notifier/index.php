<?php
/* @var $this yii\web\View */

use common\modules\notifier\models\Sms;
use common\modules\userInterface\models\UserInterface;
use yii\grid\GridView;

\common\modules\patient\assets\PatientCommunicationsCentre::register($this);
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="notifier-default-index">
    <h1>Сообщения</h1>
    <div class="row">
        <div class="col-lg-12">
            Пользователь <span id="current_user"></span>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
           <textarea class="form-control" rows="3" id="wa_msg_text"></textarea>
            <button class="button btn-primary" id="wa_send_btn">Отправить сообщение whatsapp</button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            WhatsUp
            <iframe id="wazzup_frame" src="" allow="microphone *; clipboard-write *" width="100%"
                    height="500px"></iframe>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h2>Звонки</h2>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h2>Смс</h2>
            <div class="sms-index">




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
//                        [
//                            'attribute' => 'patient_id',
//                            'value' => function ($data) {
//                                return $data->patient->fullName;
//                            }
//                        ],
//                        'phone',
//                        //'sms_id',
////            'status',
//                        [
//                            'attribute' => 'status',
//                            'value' => function($data){
//                                return Sms::getStatusList()[$data->status];
//                            }
//                        ],
////            'type',
//                        [
//                            'attribute' => 'type',
//                            'value' => function ($data) {
//                                return Sms::getTypeList()[$data->type];
//                            }
//                        ],
                        [
                                'attribute'=>'text',
                                'contentOptions' => ['style' => 'white-space: nowrap;white-space: pre-wrap;']
                        ],
//            ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
