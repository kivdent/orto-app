<?php

namespace common\modules\statistics\models;

use common\modules\pricelists\models\Pricelist;
use common\modules\reports\models\FinancialPeriods;

class Material extends StatisticsCount
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->pricelistType=Pricelist::TYPE_MATERIALS;
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
}