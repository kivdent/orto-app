<?php

namespace common\modules\statistics\models;

use common\modules\employee\models\Employee;

class KaldinTables extends \yii\base\Model
{
    const PERIOD_MONTH = 'month';

    /**
     * @param string $startDate
     * @param int $period
     * @return KaldinReport[]
     */
    public static function getReportForPeriod(string $startDate, int $period): array
    {
        $reports = [];
        foreach (Employee::getWorkedDoctors() as $doctor) {

            $reports[] = new KaldinReport([
                'startDate' => $startDate,
                'period' => $period,
                'doctor' => $doctor
            ]);
        }
        return $reports;
    }
}