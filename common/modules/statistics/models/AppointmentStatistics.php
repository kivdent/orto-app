<?php

namespace common\modules\statistics\models;

use common\modules\schedule\models\Appointment;
use common\modules\schedule\models\AppointmentsDay;
use yii\db\ActiveRecord;
use DateTime;
use yii\helpers\ArrayHelper;

/**
 *
 * @property-read Appointment[] $appointmentsMadeOnDate
 * @property-read int $initialAppointment
 * @property-read int $countAppointment
 * @property DateTime $date;
 */
class AppointmentStatistics extends \yii\base\Model

{
    public $date;//DateTime

    public static function getForDate(\DateTimeInterface $date)
    {
        return new self([
            'date' => $date
        ]);
    }

    /**
     * @param \DateTime $start_date
     * @param int $duration
     * @return AppointmentStatistics[]|null
     */
    public static function getForPeriod(\DateTime $start_date, int $duration = 1): array
    {
        $appointmentStatistics = [];
        $date = \DateTimeImmutable::createFromMutable($start_date);
        $end_date = \DateTimeImmutable::createFromMutable($start_date);
        $end_date =$end_date->modify('+ ' . $duration . ' days');
        for ($date; $date <= $end_date; $date=$date->modify('+ 1 day')) {

            $appointmentStatistics[] = self::getForDate($date);
        }
        return $appointmentStatistics;
    }

    /**
     * @return Appointment[]
     */
    public function getAppointmentsMadeOnDate()
    {
        $appoinments = [];
//        $appointmentsDays = AppointmentsDay::getAppointmentsDayForDate($this->date->format('U'));
//        if ($appointmentsDays !== null) {
//            foreach ($appointmentsDays as $appointmentsDay) {
//                $appoinments += Appointment::getAppointmentsForAppointmentDay($appointmentsDay);
//            }
//        }
        $appoinments=Appointment::find()
            ->where(['>=','created_at',$this->date->format('Y-m-d'.' 00:00:00')])
            ->andWhere(['<=','created_at',$this->date->format('Y-m-d 23:59:59')])
            ->all();
        return $appoinments;
    }
    public function getCountAppointment(){
        return count($this->appointmentsMadeOnDate);
    }
    public function getInitialAppointment(){
        $count=0;
        foreach ($this->appointmentsMadeOnDate as $appointment){
            if ($appointment->isInitialOnDate()) $count++;
        }
        return $count;
    }
    public function getByEmployee(){

    }
}