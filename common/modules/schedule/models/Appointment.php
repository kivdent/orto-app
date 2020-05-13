<?php


namespace common\modules\schedule\models;

use common\modules\patient\models\Patient;

/**
 * @property Patient $patient
 * @property  AppointmentsDay $appointments_day
 */
class Appointment extends \common\models\Appointment
{
    const SMS_SENT = 7;
    public static $status_list = [self::SMS_SENT => 'Отправлено смс'];

    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'PatID']);
    }

    public function getAppointments_day()
    {
        return $this->hasOne(AppointmentsDay::className(), ['id' => 'dayPR']);
    }
}