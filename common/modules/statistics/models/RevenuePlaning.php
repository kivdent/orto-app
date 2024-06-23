<?php

namespace common\modules\statistics\models;

use common\modules\reports\models\FinancialPeriods;
use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\base\Model;


class RevenuePlaning extends Model
{

    public $startDate;
    public $endDate;

    public $dailyRevenue;

    public function __construct($config = [])
    {
        parent::__construct($config);
        if (is_null($this->startDate) or $this->startDate == '') {
            $this->startDate = date('01.m.Y');
            $this->endDate = date('d.m.Y', strtotime($this->startDate . '+1 month'));
        }

        $this->dailyRevenue = $this->getDailyRevenue();
    }

    public static function forFinancialPeriod(FinancialPeriods $financialPeriod)
    {
        return new self([
            'startDate' => UserInterface::getFormatedDate($financialPeriod->nach),
            'endDate' => UserInterface::getFormatedDate($financialPeriod->okonch)
        ]);
    }

    /**
     * @return DailyRevenue[]
     */
    public function getDailyRevenue(): array
    {
        $date = date('d.m.Y', strtotime($this->startDate . ' -1 month'));

        $doctorStatistics = DoctorStatistics::getForFinancialPeriod(FinancialPeriods::getPeriodForDate($date));

        foreach ($doctorStatistics->clinics as $clinic) {
            $dailyRevenues[$clinic] = [];
            for ($date = strtotime($this->startDate); $date <= strtotime($this->endDate); $date = strtotime(date('d.m.Y', $date) . ' +1 day')) {

                //$dailyRevenues[$clinic]= $dailyRevenues[$clinic];
                foreach (DailyRevenue::getForDate(date('d.m.Y', $date), $doctorStatistics->financial[$clinic]) as $doctorId=> $dailyRevenuePlan){
                    if (isset($dailyRevenues[$clinic][$doctorId])){
                        $dailyRevenues[$clinic][$doctorId]+=$dailyRevenuePlan;
                    }else{
                        $dailyRevenues[$clinic][$doctorId]=$dailyRevenuePlan;
                    }
                }
            }
        }
        return $dailyRevenues;
    }
}