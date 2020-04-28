<?php


namespace common\modules\reports\models;


use common\modules\cash\models\Payment;
use common\modules\catalogs\models\PaymentType;
use common\modules\employee\models\Employee;
use common\modules\userInterface\models\UserInterface;
use yii\base\Model;

class PaymentReport extends Model
{
    public $summary = 0;
    public $table = [];
    public $financialPeriod;

    public static function getAllForPeriod(Employee $employee, FinancialPeriods $financialPeriod)
    {
        $table = [];
        $payments = Payment::find()
            ->where(['>=', 'oplata.date', $financialPeriod->nach])
            ->andWhere(['<=', 'oplata.date', $financialPeriod->okonch])
            ->joinWith('invoice')
            ->andWhere(['invoice.doctor_id' => $employee->id])
            ->all();
        $report = new self();
        if (!$payments) {
            return $table;
        }
        foreach ($payments as $payment) {
            $row['date'] = $payment->date;
            $row['vnes'] = $payment->vnes;
            $row['VidOpl'] = PaymentType::getList()[$payment->VidOpl];
            $report->summary+=$row['vnes'];
            $report->table[] = $row;
        }
        return $report;
    }
}