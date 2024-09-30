<?php

namespace common\modules\statistics\models;

use common\modules\patient\models\Patient;
use common\modules\schedule\models\Appointment;
use common\modules\schedule\models\AppointmentsDay;
use yii\db\ActiveRecord;
use DateTime;
use yii\helpers\ArrayHelper;

/**
 *
 * @property-read Appointment[] $appointmentsMadeOnDate
 * @property-read Appointment[] $appointmentsOnDate
 * @property-read int $initialAppointment
 * @property-read int $countAppointment
 * @property-read void $byEmployee
 * @property DateTime $date;
 */
class AppointmentStatistics extends \yii\base\Model

{
    const TYPE_ON_DATE = 'appointmentsOnDate';
    const TYPE_MADE_ON_DATE = 'getAppointmentsMadeOnDate';

    public $appointmentsOnDate;
    public $appointmentsMadeOnDate;
    public $countAppointment;

    public $type = self::TYPE_MADE_ON_DATE;

    public function __construct($config = [])
    {
        parent::__construct($config);

        switch ($this->type) {
            case self::TYPE_MADE_ON_DATE:
                $this->appointmentsMadeOnDate = $this->getAppointmentsMadeOnDate();
                foreach ($this->appointmentsMadeOnDate as $appointment) {
                    $appointment->setInitialDateFlag();
                    $appointment->setStatisticsParams();
                }
                $this->countAppointment=count($this->appointmentsMadeOnDate);
                break;
            case self::TYPE_ON_DATE:
                $this->appointmentsOnDate = $this->getAppointmentsOnDate();
                foreach ($this->appointmentsOnDate as $appointment) {
                    $appointment->setInitialDateFlag();
                    $appointment->setStatisticsParams();
                }
                $this->countAppointment=count($this->appointmentsOnDate);
                break;
        }


    }

    public $date;//DateTime

    public static function getForDate(\DateTimeInterface $date,$type)
    {
        return new self([
            'date' => $date,
            'type'=>$type,
        ]);
    }

    /**
     * @param \DateTime $start_date
     * @param int $duration
     * @return AppointmentStatistics[]|null
     */
    public static function getForPeriod(\DateTime $start_date, int $duration = 1,$type=self::TYPE_MADE_ON_DATE): array
    {
        $appointmentStatistics = [];
        $date = \DateTimeImmutable::createFromMutable($start_date);
        $end_date = \DateTimeImmutable::createFromMutable($start_date);
        $end_date = $end_date->modify('+ ' . $duration . ' days');

        for ($date; $date <= $end_date; $date = $date->modify('+ 1 day')) {
            $appointmentStatistics[] = self::getForDate($date,$type);
        }

        return $appointmentStatistics;
    }

    public static function getForMonth(DateTime $start_date, $duration,$type=self::TYPE_MADE_ON_DATE)
    {
        $appointmentStatistics = [];
        $date = \DateTimeImmutable::createFromMutable($start_date);
        $end_date = \DateTimeImmutable::createFromMutable($start_date);
        $end_date = $end_date->modify('+ ' . $duration . ' days');
        for ($date; $date <= $end_date; $date = $date->modify('+ 1 day')) {
            $appointmentStatistics[] = self::getForDate($date,$type);
        }
        return $appointmentStatistics;
    }


    public function getAppointmentsOnDate()
    {
        $appoinments = Appointment::find()
            ->leftJoin('daypr', '`daypr`.`id` = `nazn`.`dayPR`')
            ->where(['`daypr`.`date`' => $this->date->format('Y-m-d')])
            ->andWhere(['nazn.status' => Appointment::STATUS_ACTIVE])
            ->leftJoin('klinikpat', '`klinikpat`.`id` = `nazn`.`PatId`')
            ->andWhere(['klinikpat.card_type' => Patient::PATIENT_TYPE_PATIENT])
            ->with('patient')
            ->with('employee')
            ->all();
        return $appoinments;
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
        $appoinments = Appointment::find()
            ->where(['>=', 'created_at', $this->date->format('Y-m-d' . ' 00:00:00')])
            ->andWhere(['<=', 'created_at', $this->date->format('Y-m-d 23:59:59')])
            ->leftJoin('klinikpat', '`klinikpat`.`id` = `nazn`.`PatId`')
            ->andWhere(['klinikpat.card_type' => Patient::PATIENT_TYPE_PATIENT])
            ->with('patient')
            ->with('employee')
            ->all();
        return $appoinments;
    }

    public function getCountAppointment()
    {
        return count($this->appointmentsMadeOnDate);
    }

    public function getInitialAppointment()
    {
        $count = 0;
        foreach ($this->appointmentsMadeOnDate as $appointment) {
            if ($appointment->initialDateFlag) $count++;
        }
        return $count;
    }

    public function getInitialAppointmentForDate()
    {
        $count = 0;
        foreach ($this->appointmentsOnDate as $appointment) {
            if ($appointment->initialDateFlag) $count++;
        }
        return $count;
    }

    public function getByEmployee()
    {

    }
}