<?php


namespace common\modules\schedule\models;

use common\modules\clinic\models\ClinicSheudles;
use common\modules\clinic\models\Workplaces;
use common\modules\employee\models\Employee;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\ArrayHelper;
use common\modules\schedule\models\Appointment;

/**
 * @property string $title
 ** @property Workplaces $workplace
 ** @property Appointment[] $appointments
 */
class AppointmentsDay extends \common\models\AppointmentsDay
{
    public static function getAppointmentsDayForDoctor($doctor_id, $date)
    {
        return self::find()->where(['vrachID' => $doctor_id, 'date' => date('Y-m-d', $date)])->one();
    }

    public static function getAppointmentsDayForDate($date)
    {
        return self::find()->where(['date' => date('Y-m-d', $date)])->all();
    }

    /**
     * @return array
     */
    public static function getTimeListForNextAppointment($doctor_id, $date, $start_time)
    {
        $list = [];
        $appointment_day = BaseSchedulesDays::getAppointmentsDayForDoctor($doctor_id, $date);
        $duration = $appointment_day->TimePat * 60;
        $start_time = strtotime($appointment_day->date . ' ' . $start_time) + $duration;
        $end_time = strtotime($appointment_day->date . ' ' . $appointment_day->Okonch);
        $appointments = Appointment::getAppointmentsForTimeList($appointment_day);
//        UserInterface::getVar($appointments);
        if ($appointments) {
            foreach ($appointments as $appointment) {
                $appointment_time = strtotime($appointment_day->date . ' ' . $appointment->NachNaz);
                if ($appointment_time >= $start_time) {
                    $end_time = $appointment_time;
                    break;
                }
            }
        }
        for ($time = $start_time; $time <= $end_time; $time += $duration) {
            $list[date('H:i', $time)] = date('H:i', $time);
        }
        return $list;
    }

    /**
     * @param $doctor_id int
     * @param $start_date //d.m.Y
     * @return int|null //timestamp
     */
    public static function getDateWithFreeTime($doctor_id, $start_date)
    {
        $daysCount = '360';
        $dateWithFreeTime = null;
        for ($i = 0; $i <= $daysCount; $i++) {
            $date = strtotime($start_date . " +$i days");
            $appointmentsDay = BaseSchedulesDays::getAppointmentsDayForDoctorHoliday($doctor_id, $date);
            if ($appointmentsDay != null && $appointmentsDay->vih != 1) {
                if ($appointmentsDay->isNewRecord) {
                    $dateWithFreeTime = $date;
                    break;
                } elseif ($appointmentsDay->hasFreeTimes()) {
                    $dateWithFreeTime = $date;
                    break;
                }
            }
        }

//TODO поиск дня если за год нет свободных
        return $dateWithFreeTime;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->date = date('Y-m-d', strtotime($this->date));
        return true;
    }

    public function getWorkplace()
    {
        return $this->hasOne(Workplaces::className(), ['id' => 'rabmestoID']);
    }

    public function getTitle()
    {
        return $this->vih == 0 ? 'Рабочий' : 'Выходной';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'vih' => 'Выходной',
            'rabmestoID' => 'Рабочее место',
            'Nach' => 'Начало',
            'Okonch' => 'Окончание',
            'TimePat' => 'Время',
            'vrachID' => 'Врач',
        ];
    }

    public function getAppointments()
    {
        return $this->hasMany(Appointment::className(), ['dayPR' => 'id']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Employee::className(), ['id' => 'vrachID']);
    }

    public function getAppointmentForTime($time)
    {
        return Appointment::find()
            ->where(['dayPR' => $this->id, 'status' => Appointment::STATUS_ACTIVE])
            ->andWhere('NachNaz=\'' . date('H:i:s', $time) . '\'')
            ->one();
    }

    public function hasActiveAppointments()
    {
        return (bool)Appointment::find()
            ->where(['dayPR' => $this->id, 'status' => Appointment::STATUS_ACTIVE])
            ->all();
    }

    public function getTimeListBeforeFirstAppointment()
    {
        $list = [];
        $duration = $this->TimePat * 60;
        $start_time = strtotime($this->date . ' ' . ClinicSheudles::getStart_time());
        $end_time = strtotime($this->date . ' ' . ClinicSheudles::getEnd_time());
        $appointments = Appointment::getAppointmentsForTimeList($this);
        if ($appointments) {
            $end_time = strtotime($this->date . ' ' . reset($appointments)->NachNaz);
        }
        for ($time = $start_time; $time <= $end_time; $time += $duration) {
            $list[date('H:i', $time)] = date('H:i', $time);
        }
        return $list;
    }

    public function getTimeListAfterLastAppointment()
    {
        $list = [];
        $duration = $this->TimePat * 60;
        $start_time = strtotime($this->date . ' ' . ClinicSheudles::getStart_time());
        $end_time = strtotime($this->date . ' ' . ClinicSheudles::getEnd_time());
        $appointments = Appointment::getAppointmentsForTimeList($this);
        if ($appointments) {
            $start_time = strtotime($this->date . ' ' . end($appointments)->OkonchNaz);
        }
        for ($time = $start_time; $time <= $end_time; $time += $duration) {
            $list[date('H:i', $time)] = date('H:i', $time);
        }
        return $list;
    }

    /**
     * @return bool
     */

    public function hasFreeTimes()
    {
        $appointments = Appointment::getAppointmentsForTimeList($this);
        $appointments =ArrayHelper::map(ArrayHelper::toArray($appointments), 'NachNaz', 'OkonchNaz');

        if (array_key_first($appointments) != $this->Nach) {
            return true;
        } elseif ($appointments[array_key_last($appointments)] != $this->Okonch) {
            return true;
        }
        foreach ($appointments as $NachNaz => $OkonchNaz) {
            if (!array_key_exists($OkonchNaz, $appointments) and array_key_last($appointments) != $NachNaz) {
                return true;
            }
        }
        return false;
    }
}