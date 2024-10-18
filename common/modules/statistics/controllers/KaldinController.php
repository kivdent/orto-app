<?php

namespace common\modules\statistics\controllers;

use common\modules\employee\models\Employee;
use common\modules\statistics\models\KaldinReport;
use common\modules\statistics\models\KaldinTables;

class KaldinController extends \yii\web\Controller
{
    public function actionReport($start_date = 'now', $period = KaldinTables::PERIOD_MONTH)
    {

        $start_date = date('01.m.Y', strtotime($start_date));

        if ($period == KaldinTables::PERIOD_MONTH and date('m', strtotime($start_date)) == date('m')) {
            $period = date('j');
        } else if ($period == KaldinTables::PERIOD_MONTH) {
            $period = date('t', strtotime($start_date));
        }
        $reports = KaldinTables::getReportForPeriod($start_date, $period);
        return $this->render('report', [
            'reports' => $reports,
            'startDate' => $start_date,
            'period' => KaldinTables::PERIOD_MONTH
        ]);

    }

    public function actionDoctorReport($doctor_id, $start_date = 'now', $period = KaldinTables::PERIOD_MONTH)
    {

        $start_date = date('01.m.Y', strtotime($start_date));

        if ($period == KaldinTables::PERIOD_MONTH) $period = date('t', strtotime($start_date));

        $report = new KaldinReport([
            'startDate' => $start_date,
            'period' => $period,
            'doctor' => Employee::findOne($doctor_id),
        ]);

        return $this->render('doctor_report', [
            'report' => $report,
            'startDate' => $start_date,
            'period' => $period,
            'doctor_id' => $doctor_id,
        ]);

    }

    public function actionVolume()
    {
        return $this->render('volume');
    }


    public function actionPotential()
    {
        return $this->render('potential');
    }
}