<?php


namespace common\modules\schedule\models;

use common\modules\clinic\models\Workplaces;

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
        $start_time = strtotime($appointment_day->date . ' ' . $start_time);
        $end_time = strtotime($appointment_day->date . ' ' . $appointment_day->Okonch) - $duration;
        $appointments = Appointment::getAppointmentsForAppointmentDay($appointment_day);

        if ($appointments) {
            foreach ($appointments as $appointment) {
                $appointment_time = strtotime($appointment_day->date . ' ' . $appointment->NachNaz);
                if ($appointment_time > $start_time) {
                    $end_time = $appointment_time - $duration;
                }
            }
        }

        for ($time = $start_time; $time <= $end_time; $time += $duration) {
            $list[$time] = date('H:i', $time);
        }

        return $list;
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
}