<?php

namespace common\modules\statistics\models;

use common\modules\cash\models\Payment;
use common\modules\catalogs\models\PaymentType;
use common\modules\invoice\models\Invoice;
use common\modules\invoice\models\InvoiceItems;
use common\modules\pricelists\models\Pricelist;
use common\modules\reports\models\FinancialPeriods;
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
        $payments = $this->getPaymentsForTable([Invoice::TYPE_MANIPULATIONS, Invoice::TYPE_ORTHODONTICS]);
        return $payments;

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
        $payments = $this->getPaymentsForTable([Invoice::TYPE_MATERIALS,Invoice::TYPE_HYGIENE_PRODUCTS]);
        return $payments;
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

}