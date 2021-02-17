<?php


namespace common\modules\schedule\models;


use common\modules\userInterface\models\UserInterface;

class TimeSheet extends \common\models\TimeSheet
{
    const UNIT_TYPE_SECOND = 1;
    const UNIT_TYPE_HOUR = 3600;
    const TYPE_WEEKENDS = 'weekends';
    const TYPE_WEEKDAYS = 'weekdays';

    public static function getPeriodWorkDays($financial_period, $employee)
    {
        $count = self::find()
            ->where(['sotr' => $employee->id])
            ->andWhere(['>=', 'date', $financial_period->nach])
            ->andWhere(['<=', 'date', $financial_period->okonch])
            ->count();
        return $count;
    }


    public function getDuration()
    {
        $duration = strtotime($this->date . " " . $this->out) - strtotime($this->date . " " . $this->in);
        return $duration;
    }

    public static function getPeriodDuration($financial_period, $employee)
    {
        $duration = 0;

        $tableSheets = self::getTableSheetsForPeriod($financial_period, $employee);


        foreach ($tableSheets as $tableSheet) {
            $duration += $tableSheet->duration >= 0 ? $tableSheet->duration : 0;
        }

        return $duration;
    }

    private static function getTableSheetsForPeriod($financial_period, $employee)
    {
        $duration = 0;
        $tableSheets = self::find()
            ->where(['sotr' => $employee->id])
            ->andWhere(['>=', 'date', $financial_period->nach])
            ->andWhere(['<=', 'date', $financial_period->okonch])
            ->all();
        return $tableSheets;
    }

    public static function getPeriodDurationDayOfWeek($financial_period, $employee, $dayOfWeek = self::TYPE_WEEKDAYS)
    {
        $durationWeekends = 0;
        $durationWeekdays = 0;

        $tableSheets = self::getTableSheetsForPeriod($financial_period, $employee);

        foreach ($tableSheets as $tableSheet) {
            if (in_array($tableSheet->date, $financial_period->weekendsArray)) {
                $durationWeekends += $tableSheet->duration >= 0 ? $tableSheet->duration : 0;
            } else {
                $durationWeekdays += $tableSheet->duration >= 0 ? $tableSheet->duration : 0;
            }
        }

       return $dayOfWeek === self::TYPE_WEEKDAYS ? $durationWeekdays : $durationWeekends;
    }

}