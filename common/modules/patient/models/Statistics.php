<?php


namespace common\modules\patient\models;


use common\modules\cash\models\Payment;
use common\modules\discounts\models\DiscountCard;
use common\modules\invoice\models\Invoice;
use common\modules\pricelists\models\PricelistItems;
use common\modules\pricelists\models\Prices;
use common\modules\userInterface\models\UserInterface;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * @property DiscountCard $discountCard
 * @property string $discountCardNumber
 * @property string $discountCardType
 * @property string $professionalHygieneDate
 * @property string $professionalHygieneEmployee
 * @property string $FPDate
 * @property string $FPEmployee
 * @property string $vectorDate
 * @property string $vectorEmployee
 * @property string $orthopedicsDate
 * @property string $orthopedicsEmployee
 * @property string $orthodonticsEmployee
 * @property string $orthodonticsDate
 * @property array $yearStatistics
 */
class Statistics extends Model
{
//    const MANIPULATIONS_HYGIENE = '11,79,129,358,359,417,418,419,420,564,766,768,769';
    const MANIPULATIONS_HYGIENE = '129,159,355,358,359,417,418,419,420,564,766,768,769,1055,1056,1057,1088,1089,1090,1148';
//    const MANIPULATIONS_FP = '125,128,556,760,761';
    const MANIPULATIONS_FP = '1251,128,556,760,1061,1094';
//    const MANIPULATIONS_VECTOR = '82,404,405,421,555,557,694,759,762';
    const MANIPULATIONS_VECTOR = '82,404,405,421,555,557,759,762,367,444,755,1123,1059,1060,1061,1063,1092,1093,1095,1096';
    const MANIPULATIONS_ORTHOPEDICS = '3,9';


    public $patientId;

    public function __construct($patientId, $config = [])
    {
        $this->patientId = $patientId;

        parent::__construct($config);
    }

    public function getDiscountCard()
    {
        $discountCard = DiscountCard::find()->where(['pat' => $this->patientId])->one();

        return $discountCard;
    }

    public function getDiscountCardNumber()
    {
        return $this->discountCard ? $this->discountCard->num : "Не найдена";
    }

    public function getDiscountCardType()
    {
        return $this->discountCard ? $this->discountCard->typeName : "Не найдена";
    }

    public function getLastProfessionalHygiene()
    {
        return $this->getInvoicesByPricelistItems($this->getProfessionalHygienePrices());
    }

    public function getProfessionalHygieneDate()
    {
        $invoice = $this->getLastProfessionalHygiene();
        return $invoice ? $invoice->date : "Не проводилась";
    }

    public function getProfessionalHygieneEmployee()
    {
        $invoice = $this->getLastProfessionalHygiene();
        return $invoice ? $invoice->employeeFullName : "Не проводилась";
    }

    public function getProfessionalHygienePrices()
    {
        return $this->getPricesIdConditions(self::MANIPULATIONS_HYGIENE);
    }

    public function getPricesIdConditions($manipulations)
    {
        $prices = Prices::find()
            ->leftJoin('pricelist_items', '`pricelist_items`.`id`=`prices`.`pricelist_items_id`')
            ->where('`pricelist_items`.`id` in (' . $manipulations . ')')
            ->all();
        return implode(ArrayHelper::getColumn($prices, 'id'), ',');
    }

    private function getInvoicesByPricelistItems($pricelistItems)
    {
        return Invoice::find()
            ->where(['patient_id' => $this->patientId])
            ->leftJoin('invoice_items', '`invoice_items`.`invoice_id`=`invoice`.`id`')
            ->where('`invoice_items`.`prices_id` in (' . $pricelistItems . ')')
            ->andWhere('`invoice`.`patient_id`=' . $this->patientId)
            ->orderBy('created_at DESC')
            ->one();
    }

    public function getFPDate()
    {
        $invoice = $this->getInvoicesByPricelistItems($this->getFPPrices());
        return $invoice ? $invoice->date : "Не проводилась";
    }

    public function getFPEmployee()
    {
        $invoice = $this->getInvoicesByPricelistItems($this->getFPPrices());
        return $invoice ? $invoice->employeeFullName : "Не проводилась";
    }

    public function getFPPrices()
    {
        return $this->getPricesIdConditions(self::MANIPULATIONS_FP);
    }

    public function getVectorDate()
    {
        $invoice = $this->getInvoicesByPricelistItems($this->getVectorPrices());
        return $invoice ? $invoice->date : "Не проводилась";
    }

    public function getVectorEmployee()
    {
        $invoice = $this->getInvoicesByPricelistItems($this->getVectorPrices());
        return $invoice ? $invoice->employeeFullName : "Не проводилась";
    }

    public function getVectorPrices()
    {
        return $this->getPricesIdConditions(self::MANIPULATIONS_VECTOR);
    }


    public function getOrthopedicsDate()
    {
        $invoice = $this->getInvoicesByPricelistItems($this->getOrthopedicsPrices());
        return $invoice ? $invoice->date : "Не проводилась";
    }

    public function getOrthodonticsDate()
    {
        //$invoice = $this->getInvoicesByPricelistItems($this->getOrthopedicsPrices());
        $invoice = $this->getInvoiceByType(Invoice::TYPE_ORTHODONTICS);
        return $invoice ? $invoice->date : "Не проводилась";
    }

    public function getOrthodonticsEmployee()
    {
        $invoice = $this->getInvoiceByType(Invoice::TYPE_ORTHODONTICS);
        return $invoice ? $invoice->employeeFullName : "Не проводилась";
    }

    public function getInvoiceByType($type)
    {
        return Invoice::find()
            ->where(['type' => $type])
            ->orderBy('created_at DESC')
            ->andWhere(['patient_id' => $this->patientId])
            ->one();
    }

    public function getOrthopedicsEmployee()
    {
        $invoice = $this->getInvoicesByPricelistItems($this->getOrthopedicsPrices());
        return $invoice ? $invoice->employeeFullName : "Не проводилась";
    }

    public function getOrthopedicsPrices()
    {
        $priceListItems = $this->getPriceListItemsFromPriceLists(self::MANIPULATIONS_ORTHOPEDICS);
        return $this->getPricesIdConditions($priceListItems);
    }

    private function getPriceListItemsFromPriceLists($pricelistIds)
    {
        return implode(ArrayHelper::getColumn(PricelistItems::find()->where('`pricelist_id` in (' . $pricelistIds . ')')->all(), 'id'), ',');
    }

    public function getYearStatistics()
    {
        $yearStatistics = [];
        $payments = Payment::getRealPaymentsForPatient($this->patientId);
        foreach ($payments as $payment) {
            $year = date('Y', strtotime($payment->date));
            $date = date('d.m.Y', strtotime($payment->date)) . ' ';
            if (isset($yearStatistics[$year])) {
                $yearStatistics[$year]['total'] += $payment->vnes;
                $yearStatistics[$year]['paymentDates'] .= $date;
            } else {
                $yearStatistics[$year]['total'] = $payment->vnes;
                $yearStatistics[$year]['paymentDates'] = $date;
            }
        }
        return $yearStatistics;
    }

    public function getYearInvoices()
    {

        $yearInvoices = [];

        $payments = Payment::getRealPaymentsForPatient($this->patientId);
        foreach ($payments as $payment) {
            $year = date('Y', strtotime($payment->date));
            $date = date('d.m.Y', strtotime($payment->date)) . ' ';
            if (isset($yearInvoices[$year])) {
                $yearInvoices[$year][]= $payment->invoice;

            } else {

                $yearInvoices[$year]=[$payment->invoice];
            }
        }
        return $yearInvoices;
    }
}