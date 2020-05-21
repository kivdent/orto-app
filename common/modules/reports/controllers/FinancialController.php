<?php

namespace common\modules\reports\controllers;

use common\modules\cash\models\Cashbox;
use common\modules\clinic\models\FinancialDivisions;
use common\modules\employee\models\Employee;
use common\modules\reports\models\DailyReport;
use common\modules\reports\models\FinancialPeriods;
use common\modules\reports\models\FinancialReports;
use common\modules\reports\models\PeriodReport;
use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class FinancialController extends \yii\web\Controller
{
    public function actionDaily($date='today')
    {
        $cashbox = Cashbox::getCurrentCashBox();
        if ($cashbox == null) {
            return $this->redirect('/cash/manage/start');
        }
        $divisions = FinancialDivisions::getDivisionList();
        $financial_report = $date=='today'?FinancialReports::getToday():FinancialReports::getForDate($date);
        return $this->render('daily', [
            'cashbox' => $cashbox,
            'financial_report' => $financial_report,
            'divisions' => $divisions,
            'print' => false,
        ]);
    }

    public function actionDailyPrint($division_id)
    {
        $cashbox = Cashbox::getCurrentCashBox();
        if ($cashbox == null) {
            return $this->redirect('/cash/manage/start');
        }
        $financial_report = FinancialReports::getToday();

        $divisions = [];
        $divisions[$division_id] = FinancialDivisions::getDivisionList()[$division_id];
        // Yii::$app->controller->layout='@frontend/views/layouts/print';
        $this->layout = '@frontend/views/layouts/print';
        return $this->render('daily_print', [
            'cashbox' => $cashbox,
            'financial_report' => $financial_report,
            'divisions' => $divisions,
            'print' => true,
        ]);
    }

    public function actionEmployeeDaily()
    {
        $daily_report = DailyReport::getToday(Yii::$app->user->identity->employe->id);
        return $this->render('employee_daily', [
            'daily_report' => $daily_report,
        ]);
    }

    public function actionGetPeriod()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {

            $year = Yii::$app->request->post('period_year');
            $month = Yii::$app->request->post('period_month');
            $period = FinancialPeriods::getPeriodForDate($year . '-' . $month . '-1');
            if (!$period->id) {
                return 'error';
            } else {
                return $period->id;
            }
        }
        return false;
    }

    public function actionEmployeePeriod($period_id = 'current', $employee_id = 'current', $employee_selectable = 'false')
    {
        if ($employee_id == 'current') {
            $employee = Yii::$app->user->identity->employe;
        } else {
            $employee = Employee::findOne($employee_id);
            if (!$employee) throw new NotFoundHttpException('Сотрудник не найден.');
        }


        if ($period_id == 'current') {
            $period_report = PeriodReport::getCurrentPeriodReport($employee);
        } else {
            $financial_period = FinancialPeriods::findOne($period_id);
            if (!$financial_period) throw new NotFoundHttpException('Период не найден.');
            $period_report = PeriodReport::getPeriodReportForDate($employee, $financial_period);
        }


        return $this->render('employee_period', [
            'period_report' => $period_report,
            'employee_selectable' => $employee_selectable
        ]);
    }
}
