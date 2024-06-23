<?php

namespace common\modules\statistics\models;

use common\modules\employee\models\Employee;
use common\modules\reports\models\FinancialPeriods;
use common\modules\schedule\models\AppointmentsDay;
use common\modules\userInterface\models\UserInterface;
use Yii;

class DailyRevenue extends \yii\base\Model
{
    public $date;
    public $doctor_id;
    public $doctorFullName;
    public $revenuePlan;
    public $durationPlan;
    public  $revenueAvg;

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->durationPlan = $this->getDurationPlan();
        $this->revenuePlan=$this->getRevenuePlan();
    }

    /**
     * @param string $date
     * @return DailyRevenue[]
     */
    public static function getForDate(string $date,$doctorStatistics): array
    {
        $dailyPlans = [];

        foreach ($doctorStatistics as $employee_id => $doctorStatistic) {
            $revenueAvg = $doctorStatistic['avg']['revenue_per_hour'];
            $dailyPlans[$employee_id][$date] = new DailyRevenue([
                'date' => $date,
                'doctor_id' => $employee_id,
                'doctorFullName' => $doctorStatistic['fullName'],
                'revenueAvg'=>$revenueAvg,

            ]);
        }
        return $dailyPlans;
    }

    /**
     * @return int
     */
    public function getDurationPlan()
    {
        $appointmentsDay = AppointmentsDay::getAppointmentsDayForDoctor($this->doctor_id, strtotime($this->date));

        return $appointmentsDay ? $appointmentsDay->durationSeconds : 0;
    }

    public function getRevenuePlan()
    {
        $revenuePlan=$this->revenueAvg*$this->durationPlan/3600;
        return $revenuePlan;
    }
}