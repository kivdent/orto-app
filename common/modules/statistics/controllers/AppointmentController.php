<?php

namespace common\modules\statistics\controllers;

use common\modules\statistics\models\AppointmentStatistics;
use common\modules\userInterface\models\UserInterface;
use DateTime;

class AppointmentController extends \yii\web\Controller
{

    public function actionIndex($start_date = 'now', $duration = 6)
    {
        if ($start_date == 'now') {
            $start_date  = new DateTime('now');
        } else {
            $start_date = DateTime::createFromFormat('d.m.Y', $start_date);
        }

        $appointmentStatistics = AppointmentStatistics::getForPeriod($start_date ,$duration);

        return $this->render('index', [
            'appointmentStatistics' => $appointmentStatistics,
            'start_date'=>$start_date->format('d.m.Y'),
            'duration' => 6,
        ]);
    }

}
