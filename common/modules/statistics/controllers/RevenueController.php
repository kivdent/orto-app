<?php

namespace common\modules\statistics\controllers;

use common\modules\reports\models\FinancialPeriods;
use common\modules\statistics\models\ClinicStatistic;
use common\modules\statistics\models\HygieneProducts;
use common\modules\statistics\models\Material;
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
        $material = Material::getForFinancialPeriod($this->getFinancialPeriod());
        $clinicStatistic = ClinicStatistic::getForFinancialPeriod($this->getFinancialPeriod());
        return $this->render('index', [
            'hygieneProductsStatistics' => $hygieneProductsStatistics,
            'material' => $material,
            'clinicStatistic' => $clinicStatistic,
        ]);
    }

    public function actionHygieneProduct($financialPeriodId = null)
    {
        $hygieneProductsStatistics = HygieneProducts::getForFinancialPeriod($this->getFinancialPeriod());
        return $this->render('hygiene-product', [
            'hygieneProductsStatistics' => $hygieneProductsStatistics,
        ]);
    }

    public function actionMaterial($financialPeriodId = null)
    {
        $material = Material::getForFinancialPeriod($this->getFinancialPeriod());
        return $this->render('material', [
            'material' => $material,
        ]);
    }

    public function actionClinicStatistic($type)
    {
        if (Yii::$app->request->get('year')){
            $clinicStatistic = ClinicStatistic::getForYear(Yii::$app->request->get('year'));
        }
            else {
                $clinicStatistic = ClinicStatistic::getForFinancialPeriod($this->getFinancialPeriod());
            }


        return $this->render('clinic-statistic', [
            'clinicStatistic' => $clinicStatistic,
            'type' => $type,
        ]);
    }


}
