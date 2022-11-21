<?php

namespace common\widgets\ButtonsWidget;

use common\modules\invoice\models\Invoice;
use yii\helpers\Html;
use common\modules\schedule\models\Appointment;
use common\modules\userInterface\models\UserInterface;

class AppointmentButtonsWidget extends ButtonsWidget
{
    public $appointmentId = '';

    public function __construct($config = [])
    {
        parent::__construct($config);
        $appointment=Appointment::findOne($this->appointmentId);
        $this->buttons = [
            [//Отмена
                'role_available' => $this->doctorAndRegistratorRoles,
                'text' => Html::encode("<span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>"),
                'url' => [
                    '/schedule/appointment/cancel',
                    'appointmentId' => $appointment->Id,
                ],
                'options' => [
                    'class' => 'btn btn-xs btn-danger',
                    'data' => ['confirm' => 'Вы уверены что хотите отменить пациента?', 'method' => 'post',],
                    'title' => 'Отменить',
                    'target' => '_blank'
                ]
            ],
            [
                //назначить
                'role_available' => $this->doctorAndRegistratorRoles,
                'text' => Html::encode('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>'),
                'url' => [
                    '/schedule/appointment/index',
                    'patient_id' => $appointment->PatID,
                ],
                'options' => [
                    'class' => 'btn btn-xs btn-info',
                    'title' => 'Назначить',
                    'target' => '_blank'
                ]
            ],
           [
                //Изменить
                'role_available' => $this->doctorAndRegistratorRoles,
                'text' => Html::encode('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'),
                'url' => [
                    '/schedule/appointment/update',
                    'appointmentId' => $appointment->Id,
                ],
                'options' => [
                    'class' => 'btn btn-xs btn-info',
                    'data' => ['method' => 'post',],
                    'title' => 'Изменить время',
                    'target' => '_blank'
                ]
            ],
            [
                //Изменить
                'role_available' => [UserInterface::ROLE_RECORDER,UserInterface::ROLE_SENIOR_RECORDER],
                'text' => Html::encode('<span class="glyphicon glyphicon-rub" aria-hidden="true"></span>'),
                'url' => [
                    '/invoice/manage/create',
                    'patient_id' => $appointment->PatID,
                    'appointment_id' => $appointment->Id,
                    'invoice_type' => Invoice::TYPE_MATERIALS
                ],
                'options' => [
                    'class' => 'btn btn-xs btn-info',
                    'data' => ['method' => 'post',],
                    'title' => 'Изменить время',
                    'target' => '_blank'
                ]
            ],
            //
        ];
    }

}