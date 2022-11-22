<?php

namespace common\widgets\ButtonsWidget;

use common\modules\invoice\models\Invoice;
use common\modules\invoice\models\TechnicalOrder;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;

class ScheduleAlertButtonsWidget extends ButtonsWidget
{
    public $patient_id;
    public $employee_id;

    public $alignment = self::ALIGNMENT_VERTICAL;

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setAlerts();

    }

    public function setAlerts()
    {
        $this->getInvoicesForTechnicalOrder();
        $this->getUnclosedTechnicalOrder();
        $this->getDebt();
        $this->getTodayInvoice();
    }

    private function getInvoicesForTechnicalOrder()
    {
        $date_month_ago = date('Y-m-d', strtotime('-1 month'));
        $invoices = Invoice::getInvoicesWithTechnicalItemsCompliances($this->employee_id, $this->patient_id, $this->getStartDate(), date('Y-m-d'));

        foreach ($invoices as $invoice) {
            if (!$invoice->hasTechnicalOrderForInvoice()) {
                $this->buttons[] = [
                    //назначить
                    'role_available' => $this->doctorRoles,
                    'text' => Html::encode('Выпишите наряд'),
                    'url' => [
                        '/patient/invoices',
                        'patient_id' => $this->patient_id
                    ],
                    'options' => [
                        'class' => 'btn btn-xs btn-danger',
                        'target' => '_blank'
                    ]
                ];
            }
        }
    }

    private function getUnclosedTechnicalOrder()
    {

        $unclosedTechnicalOrders = TechnicalOrder::getUnclosed($this->employee_id, $this->patient_id, $this->getStartDate(), date('Y-m-d'));

        if (!empty($unclosedTechnicalOrders)) {
            $this->buttons[] = [
                //назначить
                'role_available' => $this->doctorRoles,
                'text' => Html::encode('Закройте наряд'),
                'url' => [
                    '/patient/technical-order',
                    'patient_id' => $this->patient_id,],
                'options' => [
                    'class' => 'btn btn-xs btn-danger',
                    'target' => '_blank'
                ]
            ];
        }
    }

    private function getStartDate($monthsAgo = 1)
    {
        return date('Y-m-d', strtotime('-' . $monthsAgo . ' month'));
    }

    private function getDebt()
    {
        $button = [];
        if (!empty(Invoice::getPatientDebts($this->patient_id))) {
            if (in_array(UserInterface::getRoleNameCurrentUser(), $this->registratorRoles)) {
                $this->buttons[] = [
                    //назначить
                    'role_available' => $this->registratorRoles,
                    'text' => Html::encode('Долг'),
                    'url' => [
                        '/cash/payment/get-debt',
                    ],
                    'options' => [
                        'class' => 'btn btn-xs btn-danger',
                        'target' => '_blank'
                    ]
                ];
            } elseif (in_array(UserInterface::getRoleNameCurrentUser(), $this->doctorRoles) and !empty(Invoice::getPatientDebtsForDoctor($this->patient_id, $this->employee_id))) {
                $this->buttons[] = [
                    //назначить
                    'role_available' => $this->doctorRoles,
                    'text' => Html::encode('Долг'),
                    'url' => [
                        '/patient/invoices',
                        'patient_id' => $this->patient_id
                    ],
                    'options' => [
                        'class' => 'btn btn-xs btn-danger',
                        'target' => '_blank'
                    ]
                ];
            }
        }

    }

    private function getTodayInvoice()
    {
        $invoice = Invoice::find()
            ->where(['patient_id' => $this->patient_id])
            ->andWhere("type<>'" . Invoice::TYPE_TECHNICAL_ORDER . "'")
            ->andWhere(['doctor_id' => $this->employee_id])
            ->andWhere(['created_at' => date('Y-m-d')])
            ->one();

        if (!empty($invoice)) {
            $this->buttons[] = [
                //назначить
                'role_available' => [UserInterface::ROLE_THERAPIST],
                'text' => Html::encode('Карта'),
                'url' => [
                    '/patient/records/create',
                    'patient_id' => $this->patient_id,
                    'invoice_id' => $invoice->id,
                ],
                'options' => [
                    'class' => 'btn btn-xs btn-danger',
                    'target' => '_blank'
                ]
            ];
        }

    }
}