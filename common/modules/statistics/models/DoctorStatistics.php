<?php

namespace common\modules\statistics\models;

use common\modules\employee\models\Employee;
use common\modules\reports\models\FinancialPeriods;
use common\modules\schedule\models\TimeSheet;
use common\modules\userInterface\models\UserInterface;
use phpDocumentor\Reflection\Types\Integer;

class DoctorStatistics extends \yii\base\Model
{
    const CURRENT_PERIOD = 'current';

    const TYPE_PERIOD_FINANCIAL = 'financial_period';
    const TYPE_PERIOD_MONTH = 'month';
    const TYPE_PERIOD_YEAR = 'year';

    public $periods = [];
    public $financial = [];


    public static function getForFinancialPeriod(FinancialPeriods $financialPeriod)
    {
        return self::getForPeriod($financialPeriod->nach, $financialPeriod->okonch, self::TYPE_PERIOD_FINANCIAL);
    }

    public static function getForPeriod($startDate, $endDate, $periodType = self::TYPE_PERIOD_FINANCIAL)
    {
        $model = new self();

        $model->setPeriods($startDate, $endDate, $periodType);
        $model->setFinancial();
        return $model;
    }

    private function setFinancial()
    {
        $doctorStat = [];

        foreach (Employee::getDoctorsList() as $employee_id => $doctorFullName) {
            $employee = Employee::findOne($employee_id);
            $doctorStat[$employee_id]['fullName'] = $doctorFullName;
            $revenue_total=[];
            $seconds_total=[];

            foreach ($this->periods as $period) {
                $revenue = $this->getRevenueDoctorForPeriod($employee_id, $period['startDate'], $period['endDate']);
                $revenue_total[]=$revenue;

                $seconds = $this->getSecondsDoctorForPeriod($employee_id, $period['startDate'], $period['endDate']);
                $seconds_total[]=$seconds;

                $revenue_per_hour = $this->getRevenuePerHouse($revenue, $seconds);
                $doctorStat[$employee_id][$period['id']] = [
                    'revenue' => $revenue,
                    'seconds'=>$seconds,
                    'hour' => UserInterface::SecondsToHours($seconds),
                    'revenue_per_hour' => $revenue_per_hour];

            }
            $doctorStat[$employee_id]['avg'] = [
                'revenue' => round(array_sum($revenue_total)/count($revenue_total),2),
                'seconds'=>array_sum($seconds_total)/count($seconds_total),
                'hour' => UserInterface::SecondsToHours(array_sum($seconds_total)/count($seconds_total)),
                'revenue_per_hour' => $this->getRevenuePerHouse(array_sum($revenue_total)/count($revenue_total), array_sum($seconds_total)/count($seconds_total))
            ];;

        }
        $this->financial [] = $doctorStat;
    }

    public function getRevenueDoctorForPeriod($employee_id, $startDate, $endDate): int
    {


        $financial_result = ClinicStatistic::getForPeriod($startDate, $endDate)->getEmployeesWithFinancialActions();
        $revenue = isset($financial_result[$employee_id]) ? $financial_result[$employee_id]['payment_sum'] : 0;
        return $revenue;
    }

    public function getSecondsDoctorForPeriod($employee_id, $startDate, $endDate): int
    {

        return TimeSheet::getCustomPeriodDuration($employee_id, $startDate, $endDate);
    }

    private function getRevenuePerHouse(int $revenue, int $seconds)
    {

        return $seconds ? round($revenue / $seconds * 3600, 2) : 0;
    }

    private function setPeriods($startDate, $endDate, $periodType, $periodsBefore = 6)
    {
        switch ($periodType) {
            case self::TYPE_PERIOD_FINANCIAL:
                $periods = FinancialPeriods::find()->orderBy('id DESC')->limit($periodsBefore)->all();
                foreach ($periods as $period) {
                    array_unshift($this->periods,
                        [
                            'id' => $period->id,
                            'title' => UserInterface::getMonthNameFromDate($period->nach),
                            'startDate' => $period->nach,
                            'endDate' => $period->okonch,
                        ]);
                }
                $this->periods['avg']=[
                    'id' => 'avg',
                    'title' => 'Среднее',
                    'startDate' => '',
                    'endDate' => '',
                ];
                break;
        }
    }

//    private function getAvgForPeriods($employeePeriods): array
//    {
//        foreach ($employeePeriods as $period){
//
//        }
//        return [
//            'revenue' => $revenue,
//            'hour' => $hour,
//            'revenue_per_hour' => $revenue_per_hour];
//
//    }

}