<?php

namespace common\modules\statistics\models;

use common\modules\cash\models\Payment;
use common\modules\catalogs\models\PaymentType;
use common\modules\employee\models\Employee;
use common\modules\invoice\models\Invoice;
use common\modules\invoice\models\InvoiceItems;
use common\modules\pricelists\models\Pricelist;
use common\modules\reports\models\FinancialPeriods;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\ArrayHelper;

/**
 * @property int $commonSummary
 * @property int $doctorsSummary
 * @property int $materialSummary
 * @property string[] $titles
 * @property Payment[] $commonPayments;
 * @property Payment[] $doctorsPayments;
 * @property Payment[] $materialPayments;
 */
class ClinicStatistic extends \yii\base\Model
{


    public $startDate = "";
    public $endDate = "";

    public static function getForFinancialPeriod(FinancialPeriods $financialPeriod)
    {
        return self::getForPeriod($financialPeriod->nach, $financialPeriod->okonch);
    }

    public static function getForPeriod($startDate, $endDate)
    {
        $model = new self(
            [
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]
        );
        return $model;
    }

    public static function getForYear($year)
    {
         return self::getForPeriod("$year-01-01","$year-12-31");
    }

    public function getPaymentsByInvoiceTypeQuery($type)
    {

        return Payment::find()
            ->leftJoin('invoice', 'invoice.id=oplata.dnev')
            ->where('oplata.date>=\'' . $this->startDate . '\'')
            ->andwhere('oplata.date<=\'' . $this->endDate . '\'')
            ->andWhere('oplata.type<>' . PaymentType::TYPE_FULL_DISCOUNT)
            ->andWhere(['invoice.type' => $type]);
    }


    public function getPaymentsByInvoiceType($type)
    {
        return $this->getPaymentsByInvoiceTypeQuery($type)
            ->all();
    }

    public function getPaymentsForTable($type)
    {
        return $this->getPaymentsByInvoiceTypeQuery($type)
            ->select(['invoice.doctor_id', 'sum(oplata.vnes) as summ'])
            ->groupBy('invoice.doctor_id')
            ->asArray()
            ->all();
    }

    public function getInvoicesForTable($type)
    {
        return Invoice::find()->
        where('invoice.created_at >=\'' . $this->startDate . '\'')
            ->andWhere('invoice.created_at<=\'' . $this->endDate . '\'')
            ->andWhere(['invoice.type' => $type])
            ->groupBy('invoice.doctor_id')
            ->select(['invoice.doctor_id', 'sum(invoice.amount_payable) as invoice_sum'])
            ->asArray()
            ->all();

    }

    public function getPriceListItemsByPriceListType($type)
    {
        $items = new StatisticsCount([
            'pricelistType' => $type,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
        //$items->getGroupPositionsByPricelistType();
        return $items->getGroupPositionsByPricelistType();
    }

    private function getPaymentsSummary(array $payments)
    {
        $summ = 0;
        foreach ($payments as $payment) {
            $summ += $payment->vnes;
        }
        return $summ;
    }

    public function getTitles()
    {
        return [
            'getMaterial' => 'Сумма за период по материалам',
            'getDoctors' => 'Сумма выручки врачей по клинике',
            'getCommon' => 'Сумма общей выручки по клинике'
        ];
    }

    //getDoctors

    public function getDoctorsPaymentsForTable()
    {

        $table['table'] = [];
        foreach ($this->getEmployeesWithFinancialActions() as $doctor_id => $financialResult) {
            $row['doctor_name'] = Employee::getEmployeeFullName($doctor_id);
            $row['invoice_sum'] = $financialResult['invoice_sum'];
            $row['payment_sum'] = $financialResult['payment_sum'];
            $row['debt_three_month'] =$financialResult['debt'];;
            $table['table'][] = $row;
        }
        $table['labels']=[
            'doctor_name'=>'Сотрудник',
            'invoice_sum'=>'Счета',
            'payment_sum'=>'Оплаты',
            'debt_three_month'=>'Долги за три месяца',

        ];
        return $table;
    }

    public function getDoctorsSummary()
    {
        return $this->getPaymentsSummary($this->getDoctorsPayments());
    }

    public function getDoctorsPayments()
    {
        $payments = ArrayHelper::merge($this->getPaymentsByInvoiceType(Invoice::TYPE_MANIPULATIONS), $this->getPaymentsByInvoiceType(Invoice::TYPE_ORTHODONTICS));
        return $payments;
    }


    public function getDoctorsPriceListItems()
    {
        return ArrayHelper::merge($this->getPriceListItemsByPriceListType(Pricelist::TYPE_MANIPULATIONS), $this->getPriceListItemsByPriceListType(Pricelist::TYPE_MANIPULATIONS));
    }

    public function getDoctorsSumTable()
    {
        return ArrayHelper::merge($this->getPriceListItemsByPriceListType(Pricelist::TYPE_MANIPULATIONS), $this->getPriceListItemsByPriceListType(Pricelist::TYPE_MANIPULATIONS));
    }


    //getMaterial

    public function getMaterialPriceListItems()
    {
        return $this->getPriceListItemsByPriceListType(Pricelist::TYPE_MATERIALS);
    }

    public function getMaterialPayments()
    {
        return $this->getPaymentsByInvoiceType(Invoice::TYPE_MATERIALS);
    }

    public function getMaterialSummary()
    {
        return $this->getPaymentsSummary($this->getMaterialPayments());
    }

    public function getMaterialPaymentsForTable()
    {
        $payments = $this->getPaymentsForTable([Invoice::TYPE_MATERIALS, Invoice::TYPE_HYGIENE_PRODUCTS]);
        $payments = ArrayHelper::map($payments, 'doctor_id', 'summ');
        $table['table'] = [];
        foreach ($payments as $doctor_id => $sum) {
            $row['doctor_name'] = Employee::getEmployeeFullName($doctor_id);
            $row['payment_sum'] = $sum;
            $table['table'][] = $row;
        }
        $table['labels']=[
            'doctor_name'=>'Сотрудник',
            'payment_sum'=>'Оплаты',
        ];
        return $table;
    }

    // getCommon

    public function getCommonPriceListItems()
    {
        $items = [];
        foreach (Pricelist::getTypeListToPayments() as $type) {
            $items = ArrayHelper::merge($items, $this->getPriceListItemsByPriceListType($type));
        }
//        ArrayHelper::multisort();
        return $items;
    }

    public function getCommonPayments()
    {
        return Payment::find()
            ->where('oplata.date>=\'' . $this->startDate . '\'')
            ->andwhere('oplata.date<=\'' . $this->endDate . '\'')
            ->andWhere('oplata.type<>' . PaymentType::TYPE_FULL_DISCOUNT)
            ->all();
    }

    public function getCommonSummary()
    {
        $summ = 0;
        foreach ($this->commonPayments as $payment) {
            $summ += $payment->vnes;
        }
        return $summ;
    }

    public function getCommonPaymentsForTable()
    {
        return [];
    }

    private function getEmployeesWithFinancialActions()
    {
        $payments = $this->getPaymentsForTable([Invoice::TYPE_MANIPULATIONS, Invoice::TYPE_ORTHODONTICS]);
        $invoices = $this->getInvoicesForTable([Invoice::TYPE_MANIPULATIONS, Invoice::TYPE_ORTHODONTICS]);
        $debts = $this->getDebtThreeMonth([Invoice::TYPE_MANIPULATIONS, Invoice::TYPE_ORTHODONTICS]);
        $payments = ArrayHelper::map($payments, 'doctor_id', 'summ');
        $invoices = ArrayHelper::map($invoices, 'doctor_id', 'invoice_sum');
        $debts = ArrayHelper::map($debts, 'doctor_id', 'debt_sum');
        $financial_result = [];
        foreach ($payments as $doctor_id => $payment_sum) {
            $financial_result[$doctor_id]['payment_sum'] = $payment_sum;
            $financial_result[$doctor_id]['invoice_sum'] = array_key_exists($doctor_id, $invoices) ? $invoices[$doctor_id] : 0;
            $financial_result[$doctor_id]['debt'] = array_key_exists($doctor_id, $debts) ? $debts[$doctor_id] : 0;
        }
        foreach (array_diff_key($invoices, $financial_result) as $doctor_id => $invoice_sum) {
            $financial_result[$doctor_id]['payment_sum'] = 0;
            $financial_result[$doctor_id]['invoice_sum'] = $invoice_sum;
            $financial_result[$doctor_id]['debt'] = array_key_exists($doctor_id, $debts) ? $debts[$doctor_id] : 0;

        }
        return $financial_result;

    }
    private function getDebtThreeMonth($type)
    {
        $start_date = date('Y-m-d', strtotime($this->startDate . '-3 month'));
        return Invoice::find()->
        where('invoice.created_at >=\'' . $start_date . '\'')
            ->andWhere('invoice.created_at<=\'' . $this->endDate . '\'')
            ->andWhere(['invoice.type' => $type])
            ->andWhere('invoice.paid<>invoice.amount_payable')
            ->groupBy('invoice.doctor_id')
            ->select(['invoice.doctor_id', 'sum(invoice.amount_payable) as debt_sum'])
            ->asArray()
            ->all();
    }
}