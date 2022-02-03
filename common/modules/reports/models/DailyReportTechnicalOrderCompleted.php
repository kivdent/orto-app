<?php

namespace common\modules\reports\models;

use common\modules\cash\models\Payment;
use common\modules\employee\models\Employee;
use common\modules\invoice\models\Invoice;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\ArrayHelper;

class DailyReportTechnicalOrderCompleted extends DailyReportTechnicalOrder
{
    public static function getReportForDate($employee_id, $date, $invoice_type)
    {
        $report = new self(['employee' => Employee::findOne($employee_id), 'date' => $date, 'invoice_type' => $invoice_type]);
        $report->setTable();
        $report->invoice_summary = $report->getInvoiceSummary();
        $report->coefficient_summary = $report->getCoefficientSummary();

        return $report;
    }
    function getInvoiceSummary()
    {
        $sum = 0;
        switch ($this->employee->dolzh) {
            case Employee::POSITION_TECHNICIANS:
                $sum = array_sum(array_column($this->getInvoices(), 'amount_payable'));
//                UserInterface::getVar(ArrayHelper::getColumn($this->getInvoices(), 'salarySum'));
//                $sum = array_sum(ArrayHelper::getColumn($this->getInvoices(), 'salarySum'));
                break;
            default:
                $sum = array_sum(array_column($this->getInvoices(), 'amount_payable'));
                break;
        }
        return $sum;
    }
    function getCoefficientSummary()
    {
        $sum = 0;
        /* @var $payment Payment */
        switch ($this->employee->dolzh) {
            case Employee::POSITION_TECHNICIANS:
//            Для расчёта по оплаченным заказ нарядам      $payments = Payment::find()
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
                    $sum += $invoice->paid;
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
    public function getInvoices()
    {
        $invoices = Invoice::find()
            ->andWhere(Invoice::getDateExpression($this->date))
            ->andWhere(['type' => Invoice::TYPE_TECHNICAL_ORDER])
            ->andWhere(['doctor_id'=>$this->employee->id])
            ->andWhere('paid=amount_payable')
            ->all();
        $technicalOrders = $invoices;

//        $technicalOrders = [];
//        foreach ($invoices as $invoice) {
//            switch ($this->employee->dolzh) {
//                case Employee::POSITION_TECHNICIANS:
//                    $employee_id = $invoice->doctor_id;
//                    break;
//                default:
//                    $employee_id = $invoice->technicalOrder->invoice->employee->id;
//                    break;
//            }
//
//            if ($employee_id === $this->employee->id) {
//                $technicalOrders[] = $invoice;
//            }
//        }
        return $technicalOrders;
    }
}
