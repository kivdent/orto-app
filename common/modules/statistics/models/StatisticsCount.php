<?php

namespace common\modules\statistics\models;

use yii\base\Model;
use common\modules\invoice\models\Invoice;
use common\modules\invoice\models\InvoiceItems;
use common\modules\pricelists\models\Pricelist;
use common\modules\reports\models\FinancialPeriods;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\ArrayHelper;

/**
 * @property int $summary
 * @property InvoiceItems[] $allPositionsByPricelistType;
 */
class StatisticsCount extends Model
{
    public $startDate = "";
    public $endDate = "";
    public $pricelistType;


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

    public function getAllPositionsByPricelistTypeQuery()
    {
        return InvoiceItems::find()
            ->leftJoin('invoice', 'invoice.id=invoice_items.invoice_id')
            ->leftJoin('prices', 'prices.id=invoice_items.prices_id')
            ->leftJoin('pricelist_items', 'pricelist_items.id=prices.pricelist_items_id')
            ->leftJoin('pricelist', '`pricelist`.`id`=`pricelist_items`.`pricelist_id`')
            ->where(['pricelist.type' => $this->pricelistType])
            ->andwhere('invoice.created_at>=\'' . $this->startDate . '\'')
            ->andWhere('invoice.created_at<=\'' . $this->endDate . '\'');
    }

    public function getAllPositionsByPricelistType()
    {
//        UserInterface::getVar($this->pricelistType);
        return $this->getAllPositionsByPricelistTypeQuery()->all();
    }

    public function getGroupPositionsByPricelistType()
    {
        //$this->getAllPositionsByPricelistTypeQuery()->groupBy('pricelist_items.id')->all();
        return $this->getAllPositionsByPricelistTypeQuery()
            ->select(['pricelist_items.id', 'SUM(invoice_items.quantity) as total','pricelist_items.title',])//
            ->groupBy('pricelist_items.id')
            ->asArray()
            ->all();
    }

    public function getSummary()
    {
        $summ = 0;
        foreach ($this->allPositionsByPricelistType as $position) {
            $summ += $position->summary;
        }
        return $summ;
    }
}