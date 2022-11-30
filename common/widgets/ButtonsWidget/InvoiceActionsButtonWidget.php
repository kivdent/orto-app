<?php

namespace common\widgets\ButtonsWidget;

use common\modules\invoice\models\Invoice;
use common\modules\schedule\models\Appointment;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;

class InvoiceActionsButtonWidget extends ButtonsWidget
{
    public $alignment = self::ALIGNMENT_VERTICAL;
    public $appointmentId = '';

    public function __construct($config = [])
    {
        parent::__construct($config);
        $appointment = Appointment::findOne($this->appointmentId);
        $this->buttons = [
            [//Счёт
                'role_available' => $this->doctorRoles,
                'text' => Html::encode("Счёт"),
                'url' => [
                    '/invoice/manage/create',
                    'patient_id' => $appointment->PatID,
                    'appointment_id' => $appointment->Id,
                    'invoice_type' => Invoice::TYPE_MANIPULATIONS
                ],
                'options' => [
                    'class' => 'btn btn-xs btn-info',
                    'title' => 'Выписать счёт за лечение',
                    'target' => '_blank'
                ]
            ],
            [
                //материалы
                'role_available' => $this->doctorRoles,
                'text' => Html::encode("Материалы"),
                'url' => [
                    '/invoice/manage/create',
                    'patient_id' => $appointment->PatID,
                    'appointment_id' => $appointment->Id,
                    'invoice_type' => Invoice::TYPE_MATERIALS
                ],
                'options' => [
                    'class' => 'btn btn-xs btn-info',
                    'title' => 'Выписать счёт за материалы',
                    'target' => '_blank'
                ]
            ],
            [
                //Гигиена
                'role_available' => $this->doctorAndRegistratorRoles,
                'text' => Html::encode("Гигиена"),
                'url' => [
                    '/invoice/manage/create',
                    'patient_id' => $appointment->PatID,
                    'appointment_id' => $appointment->Id,
                    'invoice_type' => Invoice::TYPE_HYGIENE_PRODUCTS
                ],
                'options' => [
                    'class' => 'btn btn-xs btn-info',
                    'title' => 'Выписать счёт за материалы',
                    'target' => '_blank'
                ]
            ],
        ];
        if ($appointment->patient->canCreateSchemeOrthodontic()) {
            $this->buttons[] = [
                //Создать рассрочку оплаты за ортодонтическое лечение
                'role_available' => [UserInterface::ROLE_ORTHODONTIST],
                'text' => Html::encode("Создать рассрочку"),
                'url' => [
                    '/invoice/scheme-orthodontics/create',
                    'patient_id' => $appointment->PatID,
                    'doctor_id' => $appointment->appointments_day->vrachID
                ],
                'options' => [
                    'class' => 'btn btn-xs btn-info',
                    'title' => 'Создать рассрочку оплаты за ортодонтическое лечение',
                    'target' => '_blank'
                ]
            ];
        } elseif ($appointment->patient->hasSchemeOrthodonticWithDoctor($appointment->appointments_day->vrachID)) {
            $this->buttons[] = [
                //Гигиена
                'role_available' => [UserInterface::ROLE_ORTHODONTIST],
                'text' => Html::encode("Cчёт за рассрочку"),
                'url' => [
                    '/invoice/manage/create-orthodontics',
                    'patient_id' => $appointment->PatID,
                    'appointment_id' => $appointment->Id,
                ],
                'options' => [
                    'class' => 'btn btn-xs btn-info',
                    'title' => 'Выписать ежемесячный счет рассрочку оплаты за ортодонтическое лечение',
                    'target' => '_blank'
                ]
            ];
        }
        $roles=$this->doctorRoles;
        array_push($roles,UserInterface::ROLE_RADIOLOGIST);

        $this->buttons[] = [
            //рентген
            'role_available' => $roles,
            'text' => Html::encode("Рентген"),
            'url' => [
                '/invoice/manage/create',
                'patient_id' => $appointment->PatID,
                'appointment_id' => $appointment->Id,
                'invoice_type'=>Invoice::TYPE_MANIPULATIONS,
                'employee_choice'=>true
            ],
            'options' => [
                'class' => 'btn btn-xs btn-info',
                'title' => 'Выписать счет за рентгенографию',
                'target' => '_blank'
            ]
        ];
    }
}