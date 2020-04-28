<?php

namespace common\modules\salary\controllers;

use common\modules\reports\models\FinancialPeriods;
use common\modules\salary\models\SalaryReport;
use common\modules\userInterface\models\UserInterface;
use yii\web\NotFoundHttpException;

class ManageController extends \yii\web\Controller
{
    public function actionFinancialPeriod()
    {
        return $this->render('financial-period');
    }

    public function actionIndex($financial_period_id = 'current')
    {
        if ($financial_period_id == 'current') {
            $salaryReports = SalaryReport::getForCurrentPeriod();
        } else {
            $financial_period = FinancialPeriods::findOne($financial_period_id);
            if ($financial_period) {
                $salaryReports=SalaryReport::getForPeriod($financial_period);
            }
            else{
                    throw new NotFoundHttpException('период не найден.');
                }
            }

        return $this->render('index', [
            'salaryReports' => $salaryReports
        ]);
    }

    public function actionSalaryCard()
    {
        return $this->render('salary-card');
    }


    public function actionPrint($financial_period_id = 'current')

    {
        $financial_period_id = 'current';

        $this->layout = '@frontend/views/layouts/print';
        $financial_period = FinancialPeriods::findOne($financial_period_id) ? FinancialPeriods::findOne($financial_period_id) : FinancialPeriods::getPeriodForCurrentDate();

        $salaryReports = $financial_period ? SalaryReport::getForPeriod($financial_period, true) : SalaryReport::getForCurrentPeriod();

        return $this->render('print', [
            'salaryReports' => $salaryReports
        ]);
    }

}
