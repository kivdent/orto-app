<?php

namespace common\modules\reports\models;

use common\modules\employee\models\Employee;
use common\modules\invoice\models\Invoice;

class DailyReportTechnicalOrderCurrent extends DailyReportTechnicalOrder
{
    public static function getReportForDate($employee_id, $date, $invoice_type)
    {
        $report = new self(['employee' => Employee::findOne($employee_id), 'date' => $date, 'invoice_type' => $invoice_type]);
        $report->setTable();
        $report->invoice_summary = $report->getInvoiceSummary();
        $report->coefficient_summary = $report->getCoefficientSummary();

        return $report;
    }
    public function getInvoices()
    {
        $invoices = Invoice::find()
            ->andWhere(Invoice::getDateExpression($this->date))
            ->andWhere(['type' => Invoice::TYPE_TECHNICAL_ORDER])
            ->andWhere(['doctor_id'=>$this->employee->id])
            ->andWhere('paid<>amount_payable')
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