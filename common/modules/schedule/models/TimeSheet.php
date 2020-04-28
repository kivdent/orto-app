<?php


namespace common\modules\schedule\models;


use common\modules\userInterface\models\UserInterface;

class TimeSheet extends \common\models\TimeSheet
{
    const UNIT_TYPE_SECOND = 1;
    const UNIT_TYPE_HOUR = 3600;

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
        $tableSheets = self::find()
            ->where(['sotr' => $employee->id])
            ->andWhere(['>=', 'date', $financial_period->nach])
            ->andWhere(['<=', 'date', $financial_period->okonch])
            ->all();


        foreach ($tableSheets as $tableSheet) {
            $duration += $tableSheet->duration >= 0 ? $tableSheet->duration : 0;
        }

        return $duration;
    }

}