<?php


namespace common\modules\reports\models;


use common\modules\cash\models\Payment;
use common\modules\catalogs\models\PaymentType;
use common\modules\employee\models\Employee;
use common\modules\invoice\models\Invoice;
use common\modules\invoice\models\TechnicalOrder;
use common\modules\pricelists\models\Pricelist;
use common\modules\userInterface\models\UserInterface;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class InvoiceReport extends Model
{
    public $summary = 0;
    public $table = [];
    public $financialPeriod;
    public $summaryByPricelist = [];

    public static function getAllPaidForPeriod(Employee $employee, FinancialPeriods $financialPeriod)
    {
        $report = new self();
        $table = [];
        switch ($employee->dolzh) {
            case Employee::POSITION_TECHNICIANS:
//                $invoices = Invoice::find()
//                    ->select(TechnicalOrder::tableName().'.technical_order_invoice_id')
//                    ->where(['>=', 'oplata.date', $financialPeriod->nach])
//                    ->andWhere(['<=', 'oplata.date', $financialPeriod->okonch])
//                    ->innerJoinWith(['invoice' => function ($query) use ($employee) {
//                        $query->innerJoinWith(['technicalOrderForInvoice' => function ($q) use ($employee) {
//                            $q->onCondition([TechnicalOrder::tableName() . '.employee_id' => $employee->id]);
//                        }]);
//                    }])
//                    ->andWhere('invoice.amount_payable=invoice.paid')
//                    ->groupBy(TechnicalOrder::tableName().'.technical_order_invoice_id')
//                    ->all();
                $invoices = Invoice::find()
                    ->select(TechnicalOrder::tableName() . '.technical_order_invoice_id')
                    ->andWhere('invoice.amount_payable=invoice.paid')
                    ->joinWith('payments')
                    ->innerJoinWith(['technicalOrderForInvoice' => function ($q) use ($employee) {
                        $q->onCondition([TechnicalOrder::tableName() . '.employee_id' => $employee->id]);
                    }])
                    ->andWhere(['>=', 'oplata.date', $financialPeriod->nach])
                    ->andWhere(['<=', 'oplata.date', $financialPeriod->okonch])
                    ->groupBy(TechnicalOrder::tableName() . '.technical_order_invoice_id')
                    ->all();
                break;
            default:
                $invoices = Invoice::find()
                    ->select('invoice.*')
                    ->where(['doctor_id' => $employee->id])
                    ->andWhere('amount_payable=paid')
                    ->joinWith('payments')
                    ->andWhere(['>=', 'oplata.date', $financialPeriod->nach])
                    ->andWhere(['<=', 'oplata.date', $financialPeriod->okonch])
                    ->groupBy('invoice.id')
                    ->all();
                break;
        }

        if (!$invoices) {
            return $table;
        }

//        UserInterface::getVar($invoices->prepare(\Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        //UserInterface::getVar($invoices);
        foreach ($invoices as $invoice) {
//            UserInterface::getVar($invoice->getLastPaymentDate(),false);
            if ($invoice->isLastPaymentDateInPeriod($financialPeriod)) {
                $row['patient'] = $invoice->patient->fullName;
                $row['date'] = $invoice->date;
                $row['coef_price_list'] = '';
                foreach ($invoice->getSalarySumByPriceList() as $pricelist_id => $sum) {
                    if (isset($report->summaryByPricelist[$pricelist_id])) {
                        $report->summaryByPricelist[$pricelist_id]['sum'] += $sum;
                    } else {
                        $report->summaryByPricelist[$pricelist_id]['price_list'] = $pricelist_id == Invoice::TYPE_ORTHODONTICS ? 'Ортодонтия рассрочка' : Pricelist::getListArray()[$pricelist_id];
                        $report->summaryByPricelist[$pricelist_id]['sum'] = $sum;
                    }
                    $row['coef_price_list'] .= "<div class='row'>";
                    $row['coef_price_list'] .= "<div class='col-lg-6'>" . $report->summaryByPricelist[$pricelist_id]['price_list'] . "</div>";
                    $row['coef_price_list'] .= "<div class='col-lg-6'>" . $sum . "</div>";
                    $row['coef_price_list'] .= "</div>";
                }
                $row['last_date'] = '';
                foreach ($invoice->payments as $payment) {

                    $row['last_date'] .= "<div class='row'>";
                    $row['last_date'] .= "<div class='col-lg-4'>" . UserInterface::getFormatedDate($payment->date) . "</div>";
                    $row['last_date'] .= "<div class='col-lg-4'>" . $payment->vnes . "</div>";
                    $row['last_date'] .= "<div class='col-lg-4'>" . PaymentType::getList()[$payment->VidOpl] . "</div>";
                    $row['last_date'] .= "</div>";
                }

                $report->summary += $invoice->salarySum;
                $report->table[] = $row;
            }
        }
        $report->summaryByPricelist['summary']['sum'] = $report->summary;
        $report->summaryByPricelist['summary']['price_list'] = 'Итого';
        return $report;
    }

}