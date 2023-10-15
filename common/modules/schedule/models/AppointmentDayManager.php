<?php


namespace common\modules\schedule\models;


use common\modules\userInterface\models\UserInterface;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 *
 * @property-read   Appointment[] $appointmentDayHistory
 */
class AppointmentDayManager extends Model
{
    const TIME_EMPTY = 'empty';
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
    public $isHoliday = true;


    public function __construct($config = [])
    {
        parent::__construct($config);
        if (BaseSchedules::DoctorHas($this->doctor_id, $this->date)) {
            $this->appointmentsDay = BaseSchedulesDays::getAppointmentsDayForDoctor($this->doctor_id, $this->date);

            $this->isHoliday = false;
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
            $this->isHoliday = true;
            //UserInterface::getVar($this);
        } else {
            $this->grid = [];
            for ($time = $start_time; $time < $end_time; $time += $duration) {
                if ($this->appointmentsDay->isNewRecord) {
                    $this->grid[$time] = self::TIME_EMPTY;
                } else {
                    if ($appointment = $this->appointmentsDay->getAppointmentForTime($time)) {
                        $this->grid[$time] = $appointment;
                        $time = strtotime(date('d.m.Y', $this->date) . ' ' . $appointment->OkonchNaz) - $duration;
                    } else {
                        $this->grid[$time] = self::TIME_EMPTY;
                    }
                }
            }
        }
    }
    public function getAppointmentDayHistory(){
        $appointments=Appointment::find()->where(['dayPR'=>$this->appointmentsDay->id])->all();
        return $appointments;
    }
}