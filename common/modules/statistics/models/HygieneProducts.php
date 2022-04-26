<?php

namespace common\modules\statistics\models;

use common\modules\invoice\models\Invoice;
use common\modules\invoice\models\InvoiceItems;
use common\modules\pricelists\models\Pricelist;
use common\modules\reports\models\FinancialPeriods;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\ArrayHelper;

/**
 * @property InvoiceItems[] $allPositions
 * @property int $summary
 */

class HygieneProducts extends \yii\base\Model
{

    public $startDate = "";
    public $endDate = "";
    //public $summary = "";

    public function __construct($config = [])
    {
        parent::__construct($config);

    }

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

    public function getAllPositions()
    {
        return InvoiceItems::find()
            ->leftJoin('invoice', 'invoice.id=invoice_items.invoice_id')
            ->leftJoin('prices', 'prices.id=invoice_items.prices_id')
            ->leftJoin('pricelist_items', 'pricelist_items.id=prices.pricelist_items_id')
            ->leftJoin('pricelist', '`pricelist`.`id`=`pricelist_items`.`pricelist_id`')
            ->where(['pricelist.type' => Pricelist::TYPE_HYGIENE_PRODUCTS])
            ->andwhere('invoice.created_at>=\'' . $this->startDate . '\'')
            ->andWhere('invoice.created_at<=\'' . $this->endDate . '\'')
            ->all();

    }
    public function getSummary()
    {
        $summ = 0;
        foreach ($this->allPositions as $position) {
            //UserInterface::getVar($position->summary);
            $summ+=$position->summary;
        }
        return $summ;
    }
}