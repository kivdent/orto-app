<?php


namespace common\modules\schedule\models;


use common\modules\userInterface\models\UserInterface;
use yii\base\Model;

class AppointmentManager extends Model
{
    const DURATION_ONE_DAY = 1;
    const DURATION_WEEK = 7;
    const DURATION_SIX_DAYS = 6;

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
}