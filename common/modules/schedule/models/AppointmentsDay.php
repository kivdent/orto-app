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
        return self::find()->where(['vrachID'=>$doctor_id,'date'=>date('Y-m-d', $date)])->one();
    }

    public static function getAppointmentsDayForDate($date)
    {
        return self::find()->where(['date'=>date('Y-m-d', $date)])->all();
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
        return $this->hasMany(Appointment::className(),['dayPR'=>'id']);
    }
}