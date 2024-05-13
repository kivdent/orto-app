<?php

namespace common\modules\statistics\models;

use common\modules\invoice\models\InvoiceItems;
use common\modules\pricelists\models\Pricelist;
use common\modules\reports\models\FinancialPeriods;
use common\modules\userInterface\models\UserInterface;

class XRayCount extends StatisticsCount
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->pricelistId=Pricelist::getXrayPriceListId();
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
    public function getSummary()
    {

       // UserInterface::getVar($this->getAllPositionsByPriceListId());

        $summ = 0;
        foreach ($this->getAllPositionsByPriceListId() as $position) {
            $summ += $position->summary;
        }
        return $summ;
    }
}