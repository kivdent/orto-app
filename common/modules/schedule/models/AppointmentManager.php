<?php

namespace common\modules\schedule\models;

use common\modules\userInterface\models\UserInterface;
use yii\base\Model;

class AppointmentManager extends Model
{
    const DURATION_ONE_DAY = 1;
    const DURATION_WEEK = 7;
    const DURATION_SIX_DAYS = 6;

    const DOCTOR_IDS_ALL = 'all';

    public $start_date;
    public $end_date;
    public $doctor_id;
    public $appointmentsDays = [];

    public static function getAppointmentsDaysForDoctor($doctor_id, $start_date, $duration)
    {
//        UserInterface::getVar($doctor_id, false);
        $appointmentManager = new AppointmentManager([
            'start_date' => strtotime($start_date),
            'doctor_id' => $doctor_id,
            'end_date' => strtotime($start_date . '+' . $duration . ' days'),
        ]);
//        $appointmentManager=new AppointmentManager();
        return $appointmentManager;
    }

    /**
     * @param array $doctor_ids
     * @param string $start_date
     * @param integer $duration
     * @return AppointmentsDay[]
     */
    public static function getAppointmentsDaysForDoctors(array $doctor_ids, $start_date, $duration)
    {
        $appointmentsDays = [];
//        UserInterface::getVar($doctor_ids, false);
        foreach ($doctor_ids as $doctor_id) {
//            UserInterface::getVar($doctor_id, false);
            $appointmentsDays[$doctor_id] = self::getAppointmentsDaysForDoctor($doctor_id, $start_date, $duration);
        }
        return $appointmentsDays;
    }

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setDays();
    }

    private function setDays()
    {
        for ($date = $this->start_date; $date < $this->end_date; $date += 24 * 60 * 60) {
            $this->appointmentsDays[] = new AppointmentDayManager([
                'date' => $date,
                'doctor_id' => $this->doctor_id,
            ]);
        }
    }

    /**
     * @param  $startDate //date format d.m.Y
     */
    public static function getMonthList($startDate, $additionalText = '')
    {
        $startDate = strtotime($startDate);
        for ($i = 12; $i >= 1; $i--) {
            $date = strtotime(date('01.m.Y', $startDate) . '-' . $i . ' months');
            $monthList[$additionalText . date('d.m.Y', $date)] = UserInterface::getMonthName(date('n', $date)) . ' ' . date('Y', $date);
        }
        $monthList[$additionalText . date('d.m.Y', $startDate)] = UserInterface::getMonthName(date('n', $startDate)) . ' ' . date('Y', $startDate);
        for ($i = 1; $i <= 12; $i++) {
            $date = strtotime(date('01.m.Y', $startDate) . '+' . $i . ' months');
            $monthList[$additionalText . date('d.m.Y', $date)] = UserInterface::getMonthName(date('n', $date)) . ' ' . date('Y', $date);
        }
        return $monthList;
    }

    public static function getActiveDoctorsNameList($additionalText)
    {
        $list[$additionalText.self::DOCTOR_IDS_ALL] = 'Все';
        foreach (BaseSchedules::getActiveDoctorsNameList() as $id => $doctorName) {
            $list[$additionalText . $id] = $doctorName;
        }
        return $list;
    }
}