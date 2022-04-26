<?php

namespace common\modules\statistics\controllers;

use common\modules\reports\models\FinancialPeriods;
use common\modules\statistics\models\HygieneProducts;
use common\modules\userInterface\models\UserInterface;
use Yii;

class RevenueController extends \yii\web\Controller
{
    private function getFinancialPeriod()
    {
        if (Yii::$app->request->get('financialPeriodId') and FinancialPeriods::findOne(Yii::$app->request->get('financialPeriodId')) != null) {
            $financialPeriod = FinancialPeriods::findOne(Yii::$app->request->get('financialPeriodId'));
        } else {
            $financialPeriod = FinancialPeriods::getPeriodForCurrentDate();
        }
        return $financialPeriod;
    }

    public function actionIndex($financialPeriodId = null)
    {
//        if (!$financialPeriodId){
//            $hygieneProductsStatistics=HygieneProducts::getForFinancialPeriod(FinancialPeriods::getPeriodForCurrentDate());
//        }
//        else{
//            $hygieneProductsStatistics=HygieneProducts::getForFinancialPeriod(FinancialPeriods::findOne($financialPeriodId));
//        }

        $hygieneProductsStatistics = HygieneProducts::getForFinancialPeriod($this->getFinancialPeriod());
        return $this->render('index', [
            'hygieneProductsStatistics' => $hygieneProductsStatistics,
        ]);
    }

    public function actionHygieneProduct($financialPeriodId = null)
    {
        $hygieneProductsStatistics = HygieneProducts::getForFinancialPeriod($this->getFinancialPeriod());
        return $this->render('hygiene-product', [
            'hygieneProductsStatistics' => $hygieneProductsStatistics,
        ]);
    }

}
