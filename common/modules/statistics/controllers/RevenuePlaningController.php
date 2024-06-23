<?php

namespace common\modules\statistics\controllers;

use common\modules\reports\models\FinancialPeriods;
use common\modules\statistics\models\RevenuePlaning;
use common\modules\userInterface\models\UserInterface;
use Yii;

class RevenuePlaningController extends \yii\web\Controller
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

    public function actionIndex()
    {

        $revenuePlannings = RevenuePlaning::forFinancialPeriod($this->getFinancialPeriod());
        //UserInterface::getVar($revenuePlannings);
        return $this->render('index', [
            'revenuePlannings' => $revenuePlannings,
        ]);
    }
}