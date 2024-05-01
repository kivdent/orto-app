<?php

namespace common\modules\statistics\controllers;

use common\modules\reports\models\FinancialPeriods;
use common\modules\statistics\models\DoctorStatistics;
use Yii;

/**
 * Метрики:     |Пациенты       |Финансы            |Манипулфции|
 *              |-----------    |-----------        |-----------|
 *              |Первичные      |Отработано Часов   |
 *              |Реферативн     |Выручка
 *              |               |Выричка в час
 */
class DoctorsController extends \yii\web\Controller
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
        $doctorStatistics=DoctorStatistics::getForFinancialPeriod($this->getFinancialPeriod());
        return $this->render('index',[
            'doctorStatistics'=>$doctorStatistics
        ]);
    }

}
