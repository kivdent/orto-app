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
        $duration = 0;
        $duration = strtotime($this->date . " " . $this->out) - strtotime($this->date . " " . $this->in);
        return $duration > 0 ? $duration : 0;
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
    public static function getCustomPeriodDuration($employee_id, $startDate, $endDate)
    {
        $duration = 0;

        $tableSheets = self::getTableSheetsForCustomPeriod($employee_id, $startDate, $endDate);


        foreach ($tableSheets as $tableSheet) {
            $duration += $tableSheet->duration >= 0 ? $tableSheet->duration : 0;
        }

        return $duration;
    }

    private static function getTableSheetsForPeriod($financial_period, $employee)
    {

        $tableSheets = self::find()
            ->where(['sotr' => $employee->id])
            ->andWhere(['>=', 'date', $financial_period->nach])
            ->andWhere(['<=', 'date', $financial_period->okonch])
            ->all();
        return $tableSheets;
    }
    private static function getTableSheetsForCustomPeriod($employee_id, $startDate, $endDate)
    {

        $tableSheets = self::find()
            ->where(['sotr' => $employee_id])
            ->andWhere(['>=', 'date', $startDate])
            ->andWhere(['<=', 'date', $endDate])
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sotr' => 'Сотрудник',
            'in' => 'Начало смены',
            'out' => 'Окончание смены',
            'date' => 'Дата',
        ];
    }

}