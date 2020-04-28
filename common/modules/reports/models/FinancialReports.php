<?php


namespace common\modules\reports\models;


use common\modules\cash\models\Payment;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class FinancialReports extends Model
{
    const TYPE_DAILY = 'daily';

    public $type;

    public $start_date;
    public $end_date;
    public $employee = 'all';


    public static function getToday()
    {
        $report = new FinancialReports();
        $report->type = self::TYPE_DAILY;
        $report->start_date = date('Y-m-d');
        $report->end_date = date('Y-m-d');
        return $report;
    }

    public function getSummaryPerPaymentType($paymentType_id, $division_id)
    {
        /* @var $payment \common\modules\cash\models\Payment */
        $summary = 0;
        foreach ($this->payments as $payment) {
            if ($payment->VidOpl == $paymentType_id && $payment->podr == $division_id) {
                $summary += $payment->vnes;
            }
        }
        return $summary;
    }

    public function getPayments()
    {
        $payments = Payment::find();
        $payments = $this->addCondition($payments);
        $payments = $payments->all();

        return $payments;
    }

    private function addCondition(\yii\db\ActiveQuery $query)
    {
        $query->where(['>=', 'date', $this->start_date]);
        $query->andWhere(['<=', 'date', $this->end_date]);
        return $query;
    }

    public function getEmployeeWithInvoices($division_id = 'all')
    {
        $employee = [];

        foreach ($this->getPayments() as $payment) {
            if ($payment->podr == $division_id) {
                $employee[$payment->invoice->doctor_id][] = $payment;
            }
        }
        // echo "<pre>". print_r($employee)."</pre>";die();
        return $employee;
    }

    public function getSummEmployeeWithInvoices($employee_id, $division_id = 'all')
    {
        $summ = 0;
        $summ += array_sum(ArrayHelper::getColumn($this->getEmployeeWithInvoices($division_id)[$employee_id], 'vnes'));
        return $summ;
    }

    public function getAccountCash($cashbox, $division_id)
    {
        $accountCashArray = [];
        if ($cashbox->accountCash != null) {

            foreach ($cashbox->accountCash as $accountCash) {
                if ($accountCash->podr == $division_id) {
                    $accountCashArray[] = $accountCash;
                }
            }
        }
        return $accountCashArray;
    }

    public function getAccountCashSumm($cashbox, $division_id)
    {
        $summ = 0;
        if ($this->getAccountCash($cashbox, $division_id) != null) {
            foreach ($this->getAccountCash($cashbox, $division_id) as $accountCash) {
                $summ += $accountCash->summ;
            }
        }
        return $summ;
    }

    public static function getEmployeeDailyReport($employee_id)
    {

    }
}