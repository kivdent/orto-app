<?php
/**
 * @property \common\modules\invoice\models\Invoice $invoices
 * @property \common\modules\cash\models\Payment $payments
 * @property \common\modules\employee\models\Employee $employee
 */

namespace common\modules\reports\models;


use common\modules\cash\models\Payment;
use common\modules\employee\models\Employee;
use common\modules\invoice\models\Invoice;
use common\modules\invoice\models\TechnicalOrder;
use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;
use common\modules\userInterface\models\UserInterface;
use yii\base\Model;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class DailyReportTechnicalOrder
 * @package common\modules\reports\models
 *
 * @property Employee $employee
 */
class DailyReportTechnicalOrder extends Model
{

    public $employee;
    public $date;

    public $invoice_summary = 0;
    public $payment_summary = 0;
    public $coefficient_summary = 0;

    public $table = [];
    public $labels = [
        'patient' => 'Пациент',
        'date' => 'Дата наряда',
        'invoice_sum' => 'Сумма наряда',
        'invoice' => 'Счёт',
        'delivery_date' => 'Срок сдачи',
        'completed' => 'Сдан',
        'technician' => 'Техник',
        'actions' => 'Действия',
    ];

    public $invoices;
    public $payments;

    public $invoice_type;

    public static function getToday($employee_id, $invoice_type = Invoice::TYPE_MANIPULATIONS)
    {
        return self::getReportForDate($employee_id, date('Y-m-d'), $invoice_type);
    }

    public static function getReportForDate($employee_id, $date, $invoice_type)
    {
        $report = new self(['employee' => Employee::findOne($employee_id), 'date' => $date, 'invoice_type' => $invoice_type]);
        $report->setTable();
        $report->invoice_summary = $report->getInvoiceSummary();
        $report->coefficient_summary = $report->getCoefficientSummary();

        return $report;
    }

    private function setTableToDoctor()
    {
        /* @var $invoice Invoice */

        $this->labels = [
            'patient' => 'Пациент',
            'date' => 'Дата наряда',
            'invoice_sum' => 'Сумма наряда',
            'invoice' => 'Счёт',
            'delivery_date' => 'Срок сдачи',
            'completed' => 'Сдан',
            'technician' => 'Техник',
            'actions' => 'Действия',
        ];
        foreach ($this->getInvoices() as $invoice) {

            $row = [
                'patient' => Html::a(
                        '<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>',
                        ['/patient/manage/view', 'patient_id' => $invoice->patient_id],
                        ['class' => 'btn btn-xs btn-primary']
                    ) . $invoice->getPatientFullName(),
                'date' => $invoice->date,
            ];
            $row['invoice_sum'] = InvoiceModalWidget::widget(['invoice_id' => $invoice->id]);

            $row['invoice_sum'] .= $invoice->amount_payable . ' р. ';

            $row['invoice_sum'] .= $invoice->doctorInvoiceForTechnicalOrder->amount_residual != 0 ? ' Не оплачен' : ' Оплачен';
            $row['invoice'] = InvoiceModalWidget::widget(['invoice_id' => $invoice->doctorInvoiceForTechnicalOrder->id]);
            $row['delivery_date'] = UserInterface::getFormatedDate($invoice->technicalOrder->delivery_date);
            $row['completed'] = $invoice->technicalOrder->completed ? 'Сдан' : 'Не сдан';

            $row['technician'] = $invoice->employee->fullName;

            if ($invoice->technicalOrder->completed) {
                $row['actions'] = Html::button('Вернуть в работу', [
                    'class' => 'btn btn-success btn-xs technical-order-complete',
                    'id' => $invoice->technicalOrder->id,

                ]);
            } else {
                $row['actions'] = Html::button('Сдать', [
                    'class' => 'btn btn-danger btn-xs technical-order-complete',
                    'id' => $invoice->technicalOrder->id,

                ]);
            }
            $this->table[] = $row;
        }
    }

    private function setTableTechnician()
    {
        /* @var $invoice Invoice */

        $this->labels = [
            'patient' => 'Пациент',
            'date' => 'Дата наряда',
            'invoice_sum' => 'Сумма наряда',
            'delivery_date' => 'Срок сдачи',
            'completed' => 'Сдан',
            'doctor' => 'Врач',
            //'actions' => 'Действия',
        ];
        foreach ($this->getInvoices() as $invoice) {

            $row = [
                'patient' => $invoice->getPatientFullName(),
                'date' => $invoice->date,
            ];
            $row['invoice_sum'] = InvoiceModalWidget::widget(['invoice_id' => $invoice->id]);

            $row['invoice_sum'] .= $invoice->amount_payable . ' р. ';

            $row['invoice_sum'] .= $invoice->doctorInvoiceForTechnicalOrder->amount_residual != 0 ? ' Не оплачен' : ' Оплачен';
            $row['delivery_date'] = UserInterface::getFormatedDate($invoice->technicalOrder->delivery_date);
            $row['completed'] = $invoice->technicalOrder->completed ? 'Сдан' : 'Не сдан';
            $row['doctor'] = $invoice->doctorInvoiceForTechnicalOrder->employee->fullName;

            $this->table[] = $row;
        }
    }

    private function setTable()
    {
        switch ($this->employee->dolzh) {
            case Employee::POSITION_TECHNICIANS:
                $this->setTableTechnician();
                break;
            default:
                $this->setTableToDoctor();
                break;
        }
    }


    public function getInvoices()
    {
        $invoices = Invoice::find()
            ->andWhere(Invoice::getDateExpression($this->date))
            ->andWhere(['type' => Invoice::TYPE_TECHNICAL_ORDER])
            ->all();

        $technicalOrders = [];
        foreach ($invoices as $invoice) {
            switch ($this->employee->dolzh) {
                case Employee::POSITION_TECHNICIANS:
                    $employee_id = $invoice->doctor_id;
                    break;
                default:
                    $employee_id = $invoice->technicalOrder->invoice->employee->id;
                    break;
            }

            if ($employee_id === $this->employee->id) {
                $technicalOrders[] = $invoice;
            }
        }
        return $technicalOrders;
    }

    private
    function getPaymentsForInvoice($invoice_id)
    {
        return Payment::find()->where(['dnev' => $invoice_id, 'date' => $this->date])->all();
    }

    private function getPaymentSum($invoice_id)
    {
        $sum = 0;
        $payments = $this->getPaymentsForInvoice($invoice_id);
        if ($payments) {
            foreach ($payments as $payment) {
                $sum += $payment->vnes;
            }
        }
        return $sum;
    }

    private
    function getPaymentType($invoice_id)
    {
        $types = '';
        $payments = $this->getPaymentsForInvoice($invoice_id);
        if ($payments) {
            foreach ($payments as $payment) {
                $types .= $payment->typeName;
            }
        }
        return $types;

    }

    public
    function getPaymentsNotToday()
    {
        $this->setInvoicesType();
        $payments = Payment::find()
            ->select('`oplata`.`*`')
            ->where(['date' => $this->date])
            ->innerJoinWith(['invoice' => function ($query) {
                $query->onCondition(Invoice::getDateExpression($this->date, '<>'));

            }])
            ->andWhere(['invoice.doctor_id' => $this->employee->id])
            ->andWhere(['invoice.type' => $this->setInvoicesType()])->all();
        return $payments;
    }

    public
    function getPayments()
    {
        $payments = Payment::find()
            ->where(['oplata.date' => $this->date])
            ->joinWith('invoice')
            ->andWhere(['invoice.doctor_id' => $this->employee->id])
            ->all();
        return $payments;
    }

    public
    function getInvoiceSummary()
    {
        $sum = 0;

        switch ($this->employee->dolzh) {
            case Employee::POSITION_TECHNICIANS:
                $sum = array_sum(array_column($this->getInvoices(), 'salarySum'));
                break;
            default:
                $sum = array_sum(array_column($this->getInvoices(), 'amount_payable'));
                break;
        }
        return $sum;
    }

    public
    function getPaymentSummary()
    {
        return array_sum(array_column($this->getPayments(), 'vnes'));
    }

    public
    function getCoefficientSummary()
    {
        $sum = 0;
        /* @var $payment Payment */
        switch ($this->employee->dolzh) {
            case Employee::POSITION_TECHNICIANS:
//            Для рсчёта по оплаченным заказ нарядам      $payments = Payment::find()
//                    ->select('oplata.dnev')
//                    ->where(['oplata.date' => $this->date])
//                    ->innerJoinWith(['invoice' => function ($query) {
//                        $query->innerJoinWith(['technicalOrderForInvoice' => function ($q) {
//                            $q->onCondition([TechnicalOrder::tableName() . '.employee_id' => $this->employee->id]);
//                        }]);
//                    }])
//                    ->groupBy('oplata.dnev')
//                    ->all();
                $invoices = Invoice::find()
                    ->leftJoin('technical_order', 'technical_order.technical_order_invoice_id=invoice.id')
                    ->where(['technical_order.employee_id' => $this->employee->id, 'completed' => 1, 'completed_date' => $this->date])
                    ->all();
                //UserInterface::getVar($invoices);
                foreach ($invoices as $invoice) {
                    $sum += $invoice->salarySum;
                }
                break;
            default:
                $payments = Payment::find()
                    ->select('oplata.dnev')
                    ->where(['oplata.date' => $this->date])
                    ->joinWith('invoice')
                    ->andWhere(['invoice.doctor_id' => $this->employee->id])
                    ->andWhere([Invoice::tableName() . '.type' => $this->setInvoicesType()])
                    ->groupBy('oplata.dnev')
                    ->all();
                if ($payments) {
                    foreach ($payments as $payment) {
                        if ($this->date == $payment->invoice->getLastPaymentDate() && $payment->invoice->amount_residual == 0) {
                            $sum += $payment->invoice->salarySum;
                        }
                    }
                }

                break;
        }

//        Для рсчёта по оплаченным заказ нарядам if ($payments) {
//            foreach ($payments as $payment) {
//                if ($this->date == $payment->invoice->getLastPaymentDate()
//                    && $payment->invoice->amount_residual == 0) {
//                    switch ($this->employee->dolzh) {
//                        case Employee::POSITION_TECHNICIANS:
//                            $sum += $payment->invoice->technicalOrderInvoice->salarySum;
//                            break;
//                        default:
//                            $sum += $payment->invoice->salarySum;
//                            break;
//                    }
//                }
//            }
//        }
        return $sum;
    }

    private
    function setInvoicesType()
    {
        $type = [];
//        switch ($this->employee->dolzh) {
//            case Employee::POSITION_TECHNICIANS:
//                $type = Invoice::TYPE_TECHNICAL_ORDER;
//                break;
//            default:
//                $type = [Invoice::TYPE_MANIPULATIONS, Invoice::TYPE_ORTHODONTICS];
//                break;
//        }
        switch ($this->invoice_type) {
            case  Invoice::TYPE_TECHNICAL_ORDER:
                $type = Invoice::TYPE_TECHNICAL_ORDER;
                break;
            default:
                $type = [Invoice::TYPE_MANIPULATIONS, Invoice::TYPE_ORTHODONTICS];
                break;
        }
        return $type;
    }
}