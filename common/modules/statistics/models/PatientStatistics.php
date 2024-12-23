<?php

namespace common\modules\statistics\models;

use common\modules\employee\models\Employee;
use common\modules\invoice\models\Invoice;
use common\modules\pricelists\models\PricelistItems;
use common\modules\pricelists\models\Prices;
use common\modules\userInterface\models\UserInterface;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class PatientStatistics extends Model
{
    const CURRENT_MONTH = 'current_month';
    const ENDO_IDS = 'endo_ids';
    const ORTHOPEDIC_CROWN_IDS = 'orthopedic_ids';
    const ORTHODONTICS_IDS = 'orthodontics_ids';
    const CONSULTATION_IDS = 'consultation_ids';

    public $startDateUnix;
    public $duration_months;
    public $endDateUnix;

    public static function getForPeriod($start_date, $duration_month)
    {

        if ($start_date = self::CURRENT_MONTH) {
            $patientStatistics = new self([
                'startDateUnix' => strtotime('01.' . date('m.Y')),
                'duration_months' => $duration_month,
                'endDateUnix' => strtotime('01.' . date('m.Y') . ' +' . $duration_month . ' months')
            ]);
        } else {
            $patientStatistics = new self([
                'startDateUnix' => strtotime($start_date),
                'duration_months' => $duration_month,
                'endDateUnix' => strtotime($start_date . ' +' . $duration_month . ' months')
            ]);
        }
        return $patientStatistics;
    }

    /**
     * @param Invoice $invoice
     * @return bool
     */
    public static function EarlyTherapy(Invoice $invoice): bool
    {
        $TDate = strtotime($invoice->created_at);
        $ODate = strtotime($invoice->patient->getFirstOrthodonticsConsultation());
        return $TDate < $ODate;
    }

    /**
     * @param array $priceListsIds
     * @param array $superiorCategoryIds
     * @param array $priceListItemsIds
     * @return array
     */
    private static function getPriceListItemsIdsFromDB(array $priceListsIds = [], array $superiorCategoryIds = [], array $priceListItemsIds = [])
    {
        $pricelistItems = [];
        $pricelistItems = array_merge($pricelistItems, PricelistItems::find()
            ->where(['pricelist_items.pricelist_id' => $priceListsIds])
            ->asArray()
            ->all());
        //Категории


        $pricelistItems = array_merge($pricelistItems, PricelistItems::find()
            ->where(['pricelist_items.superior_category_id' => $superiorCategoryIds])
            ->asArray()
            ->all());

        //Элементы
        $pricelistItems = array_merge($pricelistItems, PricelistItems::find()
            ->where(['pricelist_items.id' => $priceListItemsIds])
            ->asArray()
            ->all());
        $pricelistItems =ArrayHelper::getColumn($pricelistItems,'id');

        return $pricelistItems;
    }

    /**
     * @return array
     */

    public static function getConsultationPricelisitemsIds(): array
    {

        $pricelistItems=self::getPriceListItemsIdsFromDB([],[1034],[1213]);

        return $pricelistItems;
    }

    /**
     * @return array
     */
    public static function getOrhtodonticsPricelisitemsIds(): array
    {
        $pricelistItems = PricelistItems::find()
            ->where(['pricelist_items.pricelist_id' => [11, 14, 2]])
            ->asArray()
            ->all();
        $pricelistItems = ArrayHelper::getColumn($pricelistItems, 'id');
        return $pricelistItems;

    }

    /**
     * @return \common\modules\invoice\models\Invoice[]
     */
    public function getEndoCases(): array
    {
        
        $invoices = Invoice::find()
            ->leftJoin('invoice_items', 'invoice_items.invoice_id=invoice.id')
            ->leftJoin('prices', 'prices.id=invoice_items.prices_id')
            ->where(['prices.pricelist_items_id' => $this->getPriceListItemsIdsFromDB([],[],self::getPriceListItemsIds()[self::ENDO_IDS])])
            ->all();
        return $invoices;
    }

    public static function getPriceListItemsIds()
    {
        return [
            self::ENDO_IDS => [1068, 1069, 1070, 1072, 1073, 1074, 1101, 1102, 1103, 1105, 1106, 1107],
            self::ORTHOPEDIC_CROWN_IDS => [684, 689, 691, 712, 906, 445],
            self::ORTHODONTICS_IDS => self::getOrhtodonticsPricelisitemsIds(),
            self::CONSULTATION_IDS => self::getConsultationPricelisitemsIds(),
        ];
    }

    /**
     * @return \common\modules\invoice\models\Invoice[]
     */

    public function getTherapyCasesFirstDate(): array
    {
        $invoices = Invoice::find()
            ->select(['invoice.patient_id', 'min(invoice.created_at) as created_at'])
            ->leftJoin('invoice_items', 'invoice_items.invoice_id=invoice.id')
            ->leftJoin('prices', 'prices.id=invoice_items.prices_id')
            ->leftJoin('pricelist_items', 'pricelist_items.id=prices.pricelist_items_id')
            ->where(['pricelist_items.pricelist_id' => [18, 19]])
            ->groupBy('invoice.patient_id')
            ->all();

        return $invoices;
    }
    /**
     * @return \common\modules\invoice\models\Invoice[]
     */

    public function getTherapyConsultationFirstDate(): array
    {
        $invoices = Invoice::find()
            ->select(['invoice.patient_id', 'min(invoice.created_at) as created_at'])
            ->leftJoin('invoice_items', 'invoice_items.invoice_id=invoice.id')
            ->leftJoin('prices', 'prices.id=invoice_items.prices_id')
            ->leftJoin('pricelist_items', 'pricelist_items.id=prices.pricelist_items_id')
            ->where([
                'pricelist_items.id' => self::getConsultationPricelisitemsIds(),
                'invoice.doctor_id' => array_keys(Employee::getTherapistList())
            ])
            ->groupBy('invoice.patient_id')
            ->all();

        return $invoices;
    }
}