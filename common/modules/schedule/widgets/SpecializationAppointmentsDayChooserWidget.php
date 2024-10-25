<?php

namespace common\modules\schedule\widgets;

class SpecializationAppointmentsDayChooserWidget extends \yii\base\Widget
{
    public function run()
    {
        return $this->render('_specialization_appointments_day_chooser');
    }
}