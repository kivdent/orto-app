<?php


namespace common\modules\reports\models;


use common\modules\employee\models\Employee;
use common\modules\invoice\models\Invoice;
use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\base\Model;

class PeriodReport extends Model
{

    public $employee;

    public $start;
    public $end;
    public $defined = false;
    public $financial_period;

    public $daily_reports = [];

    public $invoice_summary = 0;
    public $payment_summary = 0;
    public $coefficient_summary = 0;

    public $invoice_type=Invoice::TYPE_MANIPULATIONS;

    public function getStartDate()
    {
        return $this->getFormatedDate($this->start);
    }

    public function getEndDate()
    {
        return $this->getFormatedDate($this->end);
    }

    public static function getCurrentPeriodReport($employee,$invoice_type)
    {

        $period = FinancialPeriods::getPeriodForDate(date('Y-m-d'));
        return self::getPeriodReportForDate($employee, $period, $invoice_type);
    }

    public static function getPeriodReportForDate($employee, $period,$invoice_type)
    {



        $period_report = new PeriodReport([
            'employee' => $employee,
//            'period_report'=>$period,
            'invoice_type'=>$invoice_type
        ]);
        $period_report->defined = $period->defined;
        $period_report->start = $period->nach;
        $period_report->end = $period->okonch;
        $date = $period_report->start;

        $period_report->financial_period=$period;

        while (strtotime($date) <= strtotime($period_report->end)) {
//            $daily_report = $period_report->invoice_type==Invoice::TYPE_TECHNICAL_ORDER ?
//                DailyReportTechnicalOrder::getReportForDate($period_report->employee->id, $date, $period_report->invoice_type):
//                             DailyReport::getReportForDate($period_report->employee->id, $date, $period_report->invoice_type);
            $daily_report= DailyReport::getDailyReport($period_report->employee->id, $date, $period_report->invoice_type);
            $period_report->invoice_summary += $daily_report->invoice_summary;
            $period_report->coefficient_summary += $daily_report->coefficient_summary;
            $period_report->daily_reports[] = $daily_report;
            $date = date('Y-m-d', strtotime($date . ' +1 day'));

        }

        return $period_report;
    }

    public static function getFormatedDate($date)
    {
        return Yii::$app->formatter->asDate($date, 'php:d.m.Y');
    }


}