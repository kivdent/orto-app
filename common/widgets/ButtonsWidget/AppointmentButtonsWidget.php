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
        $this->asset = [
            '\common\modules\schedule\widgets\assets\AppointmentModalAsset',
            '\common\modules\schedule\assets\AppointmentAsset',
            '\common\modules\patient\assets\PatientCommunicationsCentre'
        ];

//        $this->js="";
        parent::__construct($config);
        $appointment = Appointment::findOne($this->appointmentId);
        $this->buttons = [
            [//Отмена
                'role_available' => $this->doctorAndRegistratorRoles,
                'text' => Html::encode("<span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>"),
                'url' => ['#',
                    //'appointmentId' => $appointment->Id,
                ],
                'options' => [
                    'class' => 'btn btn-xs btn-danger btn-remove-appointment',
                    'data' => ['confirm' => 'Вы уверены что хотите отменить пациента?',],
                    'title' => 'Отменить',
                    'appointmentId' => $appointment->Id,
//                    'onclick'=>"$.ajax({
//            url: '/schedule/appointment/cancel-appointment',
//            type: 'POST',
//            data: {'appointment_id': ".$appointment->Id."},
//            success: function (response) {
//                console.log(response);
//                location.reload();
//            },
//            error: function () {
//                console.log(response);
//                alert('Ошибка запроса');
//                location.reload();
//            }
//        });",
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
                'url' => '',
                'options' => [
                    'class' => 'btn btn-xs btn-info btn-appointment-modal-update',
                    'title' => 'Изменить время',
                    'appointmentId' => $appointment->Id,
                    'doctor_id' => $appointment->appointments_day->vrachID,
                    'date' => $appointment->appointments_day->date,
                    'time' => substr($appointment->NachNaz, 0, -3),
                    'patient_id' => $appointment->PatID,
                    'OkonchNaz' => substr($appointment->OkonchNaz, 0, -3),
                    'appointment_content' => $appointment->appointment_content,

                ]
            ],
            [
                //Изменить
                'role_available' => [UserInterface::ROLE_RECORDER, UserInterface::ROLE_SENIOR_RECORDER],
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
                    'title' => 'Счёт за гигиену',
                    'target' => '_blank'
                ]
            ],
            //
            [
                //Напомнить WA
                'role_available' => [UserInterface::ROLE_RECORDER, UserInterface::ROLE_SENIOR_RECORDER],
                'text' => Html::encode('WA'),
                'url' => '',
                'options' => [
                    'class' => 'btn btn-xs btn-success btn-wa-notification',
                    'title' => 'Напомнить через Whatsapp',
                    'appointmentId' => $appointment->Id,
                    'doctor_id' => $appointment->appointments_day->vrachID,
                    'date' => UserInterface::getFormatedDate($appointment->appointments_day->date),
                    'time' => substr($appointment->NachNaz, 0, -3),
                    'patient_id' => $appointment->PatID,
                    'OkonchNaz' => substr($appointment->OkonchNaz, 0, -3),
                    'appointment_content' => $appointment->appointment_content,
                    'clinic_address'=>$appointment->getClinicAddress(),
                ]
            ],
            //
            [
                //Напомнить смс
                'role_available' => [UserInterface::ROLE_RECORDER, UserInterface::ROLE_SENIOR_RECORDER],
                'text' => Html::encode('СМС'),
                'url' => '',
                'options' => [
                    'class' => 'btn btn-xs btn-info btn-sms-notification',
                    'title' => 'Напомнить через SMS',
                    'appointmentId' => $appointment->Id,
                    'doctor_id' => $appointment->appointments_day->vrachID,
                    'date' => UserInterface::getFormatedDate($appointment->appointments_day->date),
                    'time' => substr($appointment->NachNaz, 0, -3),
                    'patient_id' => $appointment->PatID,
                    'OkonchNaz' => substr($appointment->OkonchNaz, 0, -3),
                    'appointment_content' => $appointment->appointment_content,

                ]
            ],
            //
        ];
    }
}