<?php


namespace common\modules\schedule\models;


use common\modules\clinic\models\Workplaces;
use common\modules\userInterface\models\UserInterface;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * @property  AppointmentsDay $appointmentDays
 * @property  BaseSchedulesDays $baseSchedulesDays
 * @property array $appointmentDaysArray
 */
class ScheduleDayManager extends Model
{
    const TIME_INTERVAL_IN_MINUTES = '15';
    const START_TIME = '08:00:00';
    const END_TIME = '20:00:00';
    public $date;//timestamp
    public $table; /* $this->table = [
            '' => [
                'time' => '',
                'patient_id' => '',
                'doctor_id' => '',
                'assistant_id' => '',
                'workplace' => ''
            ],
        ];*/


    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->date = isset($this->date) ? $this->date : strtotime('now');
        $this->setAppointmentTimeTable();
    }

    public function getAppointmentDays()
    {
        $appointmentDays=[];
        foreach ($this->baseSchedulesDays as $baseSchedulesDay){

            $appointmentDays[]=$baseSchedulesDay->getAppointmentsDay($this->date);
        }
        return$appointmentDays;
    }

    public function setAppointmentTimeTable()
    {
        $this->setTableFromAppointmentDays();
    }

    public function setTableFromAppointmentDays()
    {
//       foreach (Workplaces::findAll() as $workplace){
//           $time=strtotime(date('d.m.y',$this->date).' '.self::START_TIME);
//           while ($time!=strtotime(date('d.m.y',$this->date).' '.self::END_TIME)){
//               $this->getAppointmentDaysForTime();
//               $time=strtotime(date('d.m.Y H:i:s',$time). '+15 minutes');
//           }
//       }
        foreach ($this->appointmentDays as $appointmentDay) {
            $this->addAppointmentDaysToTable($appointmentDay);
        }
    }



    private function getAppointmentDaysForTime()
    {

    }

    public function getAppointmentDaysArray()
    {

        return ArrayHelper::toArray($this->appointmentDays);
    }

    private function addAppointmentDaysToTable(AppointmentsDay $appointmentDay)
    {
        if (!isset($this->table[$appointmentDay->rabmestoID])) {
            $this->table[$appointmentDay->rabmestoID] = [];
        }
        $time = strtotime($appointmentDay->date . ' ' . $appointmentDay->Nach);
        $end_time = strtotime($appointmentDay->date . ' ' . $appointmentDay->Okonch);

        for ($t = $time; $t <= $end_time; $t += 60 * 15) {
            $this->table[$appointmentDay->rabmestoID][] =
                [
                    'time' => date('H:i:s', $t),
                    'patient_id' => '',
                    'doctor_id' => $appointmentDay->vrachID,
                    'assistant_id' => '',
                    'workplace' => $appointmentDay->rabmestoID,
                ];
            //UserInterface::getVar($this->table);
        }
    }

    public function getBaseSchedulesDays()
    {
        return BaseSchedulesDays::find()
            ->where(['dayN' => date('N', $this->date)])
            ->leftJoin('raspis_pack', 'raspis_pack.id=raspis_day.raspis_pack')
            ->andWhere(['raspis_pack.status' => BaseSchedules::STATUS_ACTIVE])
            ->andWhere('raspis_pack.start_date<=\''.date('Y-m-d',$this->date).'\'')
            ->orderBy('raspis_pack.start_date DESC')
            ->all();
    }
}