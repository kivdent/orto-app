<?php

namespace common\modules\statistics\controllers;

use common\modules\reports\models\FinancialPeriods;
use common\modules\statistics\models\HygieneProducts;

class RevenueController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $hygieneProductsStatistics=HygieneProducts::getForFinancialPeriod(FinancialPeriods::getPeriodForCurrentDate());
        return $this->render('index',[
            'hygieneProductsStatistics'=>$hygieneProductsStatistics,
        ]);
    }

}
