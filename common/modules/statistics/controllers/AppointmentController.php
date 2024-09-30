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
            $start_date = new DateTime('now');
        } else {
            $start_date = DateTime::createFromFormat('d.m.Y', $start_date);
        }

        $appointmentStatistics = AppointmentStatistics::getForPeriod($start_date, $duration,AppointmentStatistics::TYPE_MADE_ON_DATE);

        return $this->render('index', [
            'appointmentStatistics' => $appointmentStatistics,
            'start_date' => $start_date->format('d.m.Y'),
            'duration' => $duration,
        ]);
    }

    public function actionMonths($start_date = 'now', $duration = 6)
    {
        if ($start_date == 'now') {
            $start_date = new DateTime('now');
        } else {
            $start_date = DateTime::createFromFormat('d.m.Y', $start_date);
        }
        $duration = $start_date->format('t');

        //$duration = 1;

        $start_date = DateTime::createFromFormat('d.m.Y', $start_date->format('1.m.Y'));
        $appointmentStatistics = AppointmentStatistics::getForMonth($start_date, $duration,AppointmentStatistics::TYPE_MADE_ON_DATE);
        return $this->render('index', [
            'appointmentStatistics' => $appointmentStatistics,
            'start_date' => $start_date->format('d.m.Y'),
            'duration' => $duration,
        ]);
    }
    public function actionAppointments($start_date = 'now')
    {
        if ($start_date == 'now') {
            $start_date = new DateTime('now');
        } else {
            $start_date = DateTime::createFromFormat('d.m.Y', $start_date);
        }

        $duration = $start_date->format('t')-1;

        $start_date = DateTime::createFromFormat('d.m.Y', $start_date->format('1.m.Y'));
        $appointmentStatistics = AppointmentStatistics::getForMonth($start_date, $duration,AppointmentStatistics::TYPE_ON_DATE);
        return $this->render('appointments', [
            'appointmentStatistics' => $appointmentStatistics,
            'start_date' => $start_date->format('d.m.Y'),
            'duration' => $duration,
        ]);
    }
    public function actionAppointmentsStats($start_date = 'now')
    {
        if ($start_date == 'now') {
            $start_date = new DateTime('now');
        } else {
            $start_date = DateTime::createFromFormat('d.m.Y', $start_date);
        }

        $duration = $start_date->format('t')-1;

        $start_date = DateTime::createFromFormat('d.m.Y', $start_date->format('1.m.Y'));
        $appointmentStatistics = AppointmentStatistics::getForMonth($start_date, $duration,AppointmentStatistics::TYPE_ON_DATE);
        return $this->render('appointments_stats', [
            'appointmentStatistics' => $appointmentStatistics,
            'start_date' => $start_date->format('d.m.Y'),
            'duration' => $duration,
        ]);
    }

}
