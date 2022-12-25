<?php


namespace common\modules\schedule\models;

use common\modules\catalogs\models\NoticeResult;
use common\modules\patient\models\Patient;

/**
 * @property Patient $patient
 * @property  AppointmentsDay $appointments_day
 * @property  AppointmentContent $appointmentContent
 * @property  NoticeResult $noticeResult
 */
class Appointment extends \common\models\Appointment
{
    const SMS_SENT = 7;

    const STATUS_ACTIVE = 'active';
    const STATUS_CANCEL = 'cancel';

    const PRESENCE_STATUS_APPEARED=1;
    const PRESENCE_STATUS_NOT_APPEARED=0;


    public static $status_list = [self::SMS_SENT => 'Отправлено смс'];

    public static function getAppointmentsForAppointmentDay(AppointmentsDay $appointment_day)
    {
        return self::find()->where(['dayPR' => $appointment_day->id, 'status' => self::STATUS_ACTIVE])->orderBy('NachNaz')->all();
    }

    public static function GetNoticeList()
    {
        return NoticeResult::getNoticeResultList();
    }

    public static function getAppointmentsForTimeList(AppointmentsDay $appointment_day)
    {

        return self::find()->where(['dayPR' => $appointment_day->id, 'status' => self::STATUS_ACTIVE])->orderBy('NachNaz')->all();

    }

    public static function getSortedByDate($patient_id)
    {
        return self::find()
            ->where(['PatID'=>$patient_id])
            ->leftJoin('daypr','nazn.dayPR=daypr.id')
            ->orderBy('daypr.date DESC')
            ->all();
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'PatID']);
    }

    public function getAppointments_day()
    {
        return $this->hasOne(AppointmentsDay::className(), ['id' => 'dayPR']);
    }

    public function getAppointmentContent()
    {
        return $this->hasOne(AppointmentContent::class, ['id' => 'SoderzhNaz']);
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
            'appointment_content' => 'Содержание приёма',
        ];
    }

    public function AppointmentPresence()
    {
        return ($this->NachPr=="00:00:00" and $this->Yavka==self::PRESENCE_STATUS_APPEARED);
    }

    public function AppointmentStarted()
    {
        return ($this->NachPr<>"00:00:00" and $this->OkonchPr=="00:00:00");
    }

    public function AppointmentStopped()
    {
        return ($this->NachPr<>"00:00:00" and $this->OkonchPr<>"00:00:00");

    }
    public function getNoticeResult(){
        return $this->hasOne(NoticeResult::class,['id'=>'RezObzv']);
    }

}