<?php

namespace common\modules\schedule\widgets;

use yii\base\Widget;

class AppointmentModalWidget extends Widget
{
    public $appointment_day_id;
    public $doctor_id;
    public $date;
    public $time;
    public $patient_id;
    public $text='Назначить';

    public function run()
    {
        return $this->render('_button', [
            'appointment_day_id' => $this->appointment_day_id,
            'doctor_id' => $this->doctor_id,
            'date' => $this->date,
            'time' => $this->time,
            'patient_id' => $this->patient_id,
            'text' => $this->text,
        ]);
    }
}