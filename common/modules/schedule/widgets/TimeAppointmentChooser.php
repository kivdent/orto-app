<?php

namespace common\modules\schedule\widgets;

use common\modules\schedule\models\AppointmentManager;

class TimeAppointmentChooser extends \yii\base\Widget
{
    public $doctor_id = AppointmentManager::DOCTOR_IDS_ALL;
    public $patient_id = null;
    public $start_date;
    public $duration = AppointmentManager::DURATION_SIX_DAYS;

    public function __construct()
    {
        $this->start_date = $this->start_date ? $this->start_date : date('d.m.Y');
    }

    public function run()
    {
        return $this->render('_time_appointment_chooser', [
            'doctor_id' => $this->doctor_id,
            'patient_id' => $this->patient_id,
            'start_date'=>$this->start_date,
            'duration'=>$this->duration
        ]);
    }
}