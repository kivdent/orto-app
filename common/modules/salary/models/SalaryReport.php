<?php


namespace common\modules\salary\models;
/**
 * @property FinancialPeriods $financial_period
 */

use common\modules\cash\models\Payment;
use common\modules\catalogs\models\PaymentType;
use common\modules\clinic\models\FinancialDivisions;
use common\modules\employee\models\Employee;
use common\modules\invoice\models\Invoice;
use common\modules\pricelists\models\Pricelist;
use common\modules\reports\models\FinancialPeriods;
use common\modules\reports\models\InvoiceReport;
use common\modules\schedule\models\TimeSheet;
use common\modules\userInterface\models\UserInterface;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class SalaryReport extends Model
{
    const CLEAR_UP_DURATION = 21600;


    public $financial_period;

    public $type;

    public $table = [];
    public $labels = [];
    public $printable=false;


    public $setSalaryTableFunction = [
        SalaryCardType::TYPE_PERCENTAGE => 'setPercentageTable',
        SalaryCardType::TYPE_HOURLY => 'setHourlyTable',
        SalaryCardType::TYPE_FIXED => 'setFixedTable',
        SalaryCardType::TYPE_PERCENTAGE_FULL => 'setFullPercentageTable',
    ];

    public static function getForPeriod(FinancialPeriods $financial_period,$printable=false)
    {
        $salaryReports = [];
        foreach (SalaryCardType::getTypeList() as $type_id => $type) {
            $salaryReport = new SalaryReport([
                'financial_period' => $financial_period,
                'type' => $type_id,
                'printable' => $printable
            ]);
            call_user_func([$salaryReport, $salaryReport->setSalaryTableFunction[$type_id]]);
            $salaryReports[] = $salaryReport;
        }

        return $salaryReports;
    }

    public static function getForCurrentPeriod()
    {
        return self::getForPeriod(FinancialPeriods::getPeriodForCurrentDate());
    }

    public static function getIpForPeriod(FinancialPeriods $financial_period)
    {
        $salaryReports = [];
        $salaryReport = new SalaryReport([
            'financial_period' => $financial_period,
            'type' => 'ip',]);
        $salaryReport->setIpTables();
        return $salaryReports;
    }

    private function setPercentageTable()
    {

        $this->labels = [
            'employee' => 'Сотрудник',
        ];
        $type = SalaryCardType::TYPE_PERCENTAGE;
        $salaryCards = SalaryCard::getTypeSelection($type);
        if ($salaryCards) {
            foreach ($salaryCards as $salaryCard) {
                $table = [];
                $table['employee'] = $salaryCard->employeeName;
                $table += $this->getPriceListsSummsForPeriod($salaryCard->employee);
                //$table['orthodontics'] = $this->getOrthodonticsSumm($salaryCard->employee);
                $this->table[] = $table;
            }

        }

        $this->setEmptyColumns();

    }

    private function setHourlyTable()
    {
        $table = [];
        $this->labels = [
            'employee' => 'Сотрудник',
            'per_hour' => 'Ставка в час',
            'duration' => 'Отработано часов',
            'salary_per_hour' => 'Зарплата по часам',
            'revenue_for_services' => 'Сумма выручки за услуги'
        ];
        $type = SalaryCardType::TYPE_HOURLY;
        $salaryCards = SalaryCard::getTypeSelection($type);
        if ($salaryCards) {
            foreach ($salaryCards as $salaryCard) {
                $table['employee'] = $salaryCard->employeeName;
                $table['per_hour'] = $salaryCard->ph;
                $duration = TimeSheet::getPeriodDuration($this->financial_period, $salaryCard->employee) + self::CLEAR_UP_DURATION;
                $table['duration'] = UserInterface::SecondsToHours($duration);
               // $table['duration'] = $duration- self::CLEAR_UP_DURATION;
                $table['salary_per_hour'] = $table['per_hour'] * $duration / 3600;
                $table['revenue_for_services'] = $this->getAllPaidInvoicesSumm($salaryCard->employee);
                $this->table[] = $table;
            }
        }


    }

    private function setFixedTable()
    {
        $table = [];
        $this->labels = [
            'employee' => 'Сотрудник',
            'salary' => 'Зарплата',
        ];
        $type = SalaryCardType::TYPE_FIXED;
        $salaryCards = SalaryCard::getTypeSelection($type);
        if ($salaryCards) {
            foreach ($salaryCards as $salaryCard) {
                $table['employee'] = $salaryCard->employeeName;
                $table['salary'] = $salaryCard->stavka;
                $this->table[] = $table;
            }
        }
    }

    private function getAllPaidInvoicesSumm($employee)
    {
        $sum = 0;
        $payments = Payment::find()
            ->where(['>=', 'date', $this->financial_period->nach])
            ->andWhere(['<=', 'date', $this->financial_period->okonch])
            ->joinWith('invoice')
            ->andWhere(['invoice.doctor_id' => $employee->id])
            ->all();
        if ($payments) {
            foreach ($payments as $payment) {
                if ($payment->invoice->getLastPaymentDate() >= $this->financial_period->nach
                    && $payment->invoice->getLastPaymentDate() <= $this->financial_period->okonch
                    && $payment->invoice->amount_residual == 0) {
                    $sum += $payment->invoice->coefficientSummary * FinancialPeriods::getUETForDate($payment->invoice->created_at);
                }
            }
        }
        return $sum;
    }

    private function getPriceListsSummsForPeriod($employee)
    {
        $table = [];
        $report = InvoiceReport::getAllPaidForPeriod($employee, $this->financial_period);
        if (!$report) {
            return $table;
        }
        foreach ($report->summaryByPricelist as $pricelist_id => $summary) {
            $table[$this->getPriceListColumnName($pricelist_id)] = $summary['sum'];
            if (!isset($this->labels[$this->getPriceListColumnName($pricelist_id)])) {
                $this->labels[$this->getPriceListColumnName($pricelist_id)] = $summary['price_list'];
            }
        }
//        $payments = Payment::find()
//            ->select('oplata.dnev')
//            ->where(['>=', 'date', $this->financial_period->nach])
//            ->andWhere(['<=', 'date', $this->financial_period->okonch])
//            ->joinWith('invoice')
//            ->andWhere(['invoice.doctor_id' => $employee->id])
//            ->groupBy('oplata.dnev')
//            ->all();
////        UserInterface::getVar($payments);
//        if ($payments) {
//            foreach ($payments as $payment) {
//                if ($payment->invoice->getLastPaymentDate() >= $this->financial_period->nach
//                    && $payment->invoice->getLastPaymentDate() <= $this->financial_period->okonch
//                    && $payment->invoice->amount_residual == 0) {
//                    $table = $this->getCoeficientSumForInvoice($payment->invoice, $table);
////                   foreach($this->getCoeficientSumForInvoice($payment->invoice) as $key=>$value){
////                        if(array_key_exists($key,$table)){
////                            $table[$key]+=$value;
////                        } else{
////                            $table[$key]=$value;
////                        }
////                    }
//                }
//            }
//        }
////        UserInterface::getVar($table, false);
        return $table;
    }

    private function getCoeficientSumForInvoice($invoice, $table)
    {

        foreach ($invoice->invoiceItems as $invoiceItem) {

            $pricelist_id = $invoiceItem->prices->pricelistItems->pricelist_id;
            $uet = FinancialPeriods::getUETForDate($invoice->date);

            if (isset($table[$this->getPriceListColumnName($pricelist_id)])) {
                $table[$this->getPriceListColumnName($pricelist_id)] += $invoiceItem->coefficientSummary * $uet;
            } else {
//                echo "new";
                $table[$this->getPriceListColumnName($pricelist_id)] = $invoiceItem->coefficientSummary * $uet;
                if (!isset($this->labels[$this->getPriceListColumnName($pricelist_id)])) {
                    $this->labels[$this->getPriceListColumnName($pricelist_id)] = Pricelist::getListArray()[$pricelist_id];
                }
            }
//            UserInterface::getVar(($this->getPriceListColumnName($pricelist_id) . " " . $invoiceItem->coefficientSummary * $uet), false);
        }
        return $table;
    }

    private function getPriceListColumnName($pricelist_id)
    {
        return 'price_list_id_' . $pricelist_id;
    }

    private function setEmptyColumns()
    {

        foreach ($this->table as &$row)
            foreach ($this->labels as $label_name => $label) {
                if (!isset($row[$label_name])) {
                    $row[$label_name] = 0;
                }
            }
    }

    private function getOrthodonticsSumm($employee)
    {
        $sum = 0;
//        UserInterface::getVar($employee,false);
        $payments = $payments = Payment::find()
            ->where(['>=', 'date', $this->financial_period->nach])
            ->andWhere(['<=', 'date', $this->financial_period->okonch])
            ->joinWith('invoice')
            ->andWhere(['invoice.doctor_id' => $employee->id])
            ->andWhere(['invoice.type' => Invoice::TYPE_ORTHODONTICS])
            ->all();
        if ($payments) {
            foreach ($payments as $payment) {
                if ($payment->invoice->getLastPaymentDate() >= $this->financial_period->nach
                    && $payment->invoice->getLastPaymentDate() <= $this->financial_period->okonch
                    && $payment->invoice->amount_residual == 0) {
                    $sum += $payment->vnes;
                }
            }
        }
        return $sum;
    }

    public function setFullPercentageTable()
    {

        $this->labels = [
            'employee' => 'Сотрудник',

        ];
        $type = SalaryCardType::TYPE_PERCENTAGE_FULL;
        $salaryCards = SalaryCard::getTypeSelection($type);
        if ($salaryCards) {

            foreach ($salaryCards as $salaryCard) {
                $table = [];
                $table['employee'] = $salaryCard->employeeName;
                $table += $this->getPaymentByTypes($salaryCard->employee);
                $table += $this->getPaymentByDivision($salaryCard->employee);
                $this->table[] = $table;
            }
            $this->setEmptyColumns();
        }
    }

    private function getPaymentByTypes($employee)
    {
        $table = [];
        $payments = Payment::find()
            ->where(['>=', 'date', $this->financial_period->nach])
            ->andWhere(['<=', 'date', $this->financial_period->okonch])
            ->joinWith('invoice')
            ->andWhere(['invoice.doctor_id' => $employee->id])
            ->all();
        if ($payments) {
            foreach ($payments as $payment) {
                $columnName = $this->getPriceListColumnName($payment->VidOpl);
                if (isset($table[$columnName])) {
                    $table[$columnName] += $payment->vnes;
                } else {
                    $table[$columnName] = $payment->vnes;
                    if (!isset($this->labels[$columnName])) {
                        $this->labels[$columnName] = PaymentType::getList()[$payment->VidOpl];
                    }
                }

            }
        }
        return $table;
    }


    function setIpTables()
    {
        return true;
    }

    private function getPaymentByDivision($employee)
    {
        $table = [];
        $payments = Payment::find()
            ->where(['>=', 'date', $this->financial_period->nach])
            ->andWhere(['<=', 'date', $this->financial_period->okonch])
            ->joinWith('invoice')
            ->andWhere(['invoice.doctor_id' => $employee->id])
            ->all();
        if ($payments) {
            foreach ($payments as $payment) {
                $columnName = $this->getPriceListColumnName('div-' . $payment->podr);
                if (isset($table[$columnName])) {
                    $table[$columnName] += $payment->vnes;
                } else {
                    $table[$columnName] = $payment->vnes;
                    if (!isset($this->labels[$columnName])) {
                        $this->labels[$columnName] = FinancialDivisions::getDivisionList()[$payment->podr];
                    }
                }
            }
        }
        return $table;
    }
}