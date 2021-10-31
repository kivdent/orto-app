<?php


namespace common\modules\schedule\models;


use common\modules\userInterface\models\UserInterface;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AppointmentDayManager extends Model
{
    const TIME_EMPTY='empty';
    public $date;
    public $doctor_id;
    /**
     * @var AppointmentsDay
     */
    public $appointmentsDay;
    public $duration;
    /**
     * @var array|string
     * Фромат 'holiday'|['время'=>'appointment_id|new',]
     *
     */
    public $grid;
    public $isHoliday=false;

    public function __construct($config = [])
    {
        parent::__construct($config);
        if (BaseSchedules::DoctorHas($this->doctor_id,$this->date)) {
            $this->appointmentsDay = BaseSchedulesDays::getAppointmentsDayForDoctor($this->doctor_id, $this->date);
//            UserInterface::getVar($this->appointmentsDay,false);
            $this->setGrid();
        } else {
            $this->appointmentsDay = null;
        }
    }

    private function setGrid()
    {

        $start_time = strtotime(date('d.m.Y', $this->date) . ' ' . $this->appointmentsDay->Nach);
        $end_time = strtotime(date('d.m.Y', $this->date) . ' ' . $this->appointmentsDay->Okonch);
        $duration = $this->appointmentsDay->TimePat * 60;
//        UserInterface::getVar($start_time,false);
//        UserInterface::getVar($end_time);
        if (!$this->appointmentsDay or $this->appointmentsDay->vih == 1) {
            $this->grid = 'holiday';
            $this->isHoliday =true;

        } else {
            $this->grid = [];
            for ($time = $start_time; $time < $end_time; $time += $duration) {
//                echo $time."<br>";
//                echo $end_time."<br>";
//                echo $time + $duration."<br>";
//                echo $duration."<br>";
                if ($this->appointmentsDay->isNewRecord) {
                    $this->grid[$time] = self::TIME_EMPTY;

                } else {
                    $this->grid[$time] = 'ok';

//                    $appointment = $this->getAppointmentForTime($time);
//                    $this->grid[] = $appointment;
//                    if ($appointment instanceof Appointment) {
//                        $time = strtotime(date('d.m.Y', $this->date) . ' ' . date('H:i:s', $time)) - $duration;
//                    }
                }
            }
        }
    }

    private function getAppointmentForTime($time)
    {
        $appointmentsForDay = ArrayHelper::toArray($this->appointmentsDay->appointments, '\common\modules\schedule\models\Appointment');
    }
}