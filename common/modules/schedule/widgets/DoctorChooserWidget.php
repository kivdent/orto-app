<?php

namespace common\modules\schedule\widgets;

use common\modules\schedule\models\AppointmentManager;
use common\modules\userInterface\models\UserInterface;

class DoctorChooserWidget extends \yii\base\Widget
{
    public $doctor_id = AppointmentManager::DOCTOR_IDS_ALL;

    public function run()
    {
        return $this->render('_doctor_chooser', [
            'doctor_id' => $this->doctor_id
        ]);
    }
}