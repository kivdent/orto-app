<?php

namespace common\modules\salary\controllers;

use common\modules\reports\models\FinancialPeriods;
use common\modules\salary\models\SalaryReport;

use yii\web\NotFoundHttpException;

class SalaryReportController extends \yii\web\Controller
{

    public function actionReport($employee_id, $type_id, $financial_period_id = 'current')
    {
        if ($financial_period_id == 'current') {
            $salaryReport =  $salaryReport = new SalaryReport([
                'financial_period' => FinancialPeriods::getPeriodForCurrentDate(),
                'type' => $type_id,
            ]);
        } else {
            $financial_period = FinancialPeriods::findOne($financial_period_id);
            if ($financial_period) {
                $salaryReport =  $salaryReport = new SalaryReport([
                    'financial_period' =>FinancialPeriods::findOne($financial_period_id),
                    'type' => $type_id,
                ]);
            }
            else{
                throw new NotFoundHttpException('период не найден.');
            }
        }

        $table = $salaryReport->getEmployeeReportForPeriod($employee_id);
        return $this->render('report', ['table' => $table]);
    }
}
