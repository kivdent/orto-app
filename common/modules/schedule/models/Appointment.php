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

    const STATUS_ACTIVE='active';
    const STATUS_CANCEL='cancel';

    public static $status_list = [self::SMS_SENT => 'Отправлено смс'];

    public static function getAppointmentsForAppointmentDay(AppointmentsDay $appointment_day)
    {
        return self::find()->where(['dayPR'=>$appointment_day->id,'status'=>self::STATUS_ACTIVE])->orderBy('NachNaz')->all();
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'PatID']);
    }

    public function getAppointments_day()
    {
        return $this->hasOne(AppointmentsDay::className(), ['id' => 'dayPR']);
    }
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'PatID' => 'Пациент',
            'dayPR' => 'День приёма',
            'NachNaz' => 'Начало приёма',
            'OkonchNaz' => 'Окончание приёма',
            'SoderzhNaz' => 'Содержание приёма',
            'RezObzv' => 'Результат обзвона',
            'Yavka' => 'Явка',
            'NachPr' => 'Фактическое начало приёма',
            'OkonchPr' => 'Фактическое окончание приёма',
            'status' => 'Статус',
        ];
    }
}