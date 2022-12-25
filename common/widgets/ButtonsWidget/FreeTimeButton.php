<?php

namespace common\widgets\ButtonsWidget;

use common\modules\schedule\models\AppointmentsDay;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;

class FreeTimeButton extends ButtonsWidget
{
    public $doctor_id;
    public $start_date;
    public $url;

    public function __construct($config = [])
    {
        parent::__construct($config);
        $freeTimeDate=date('d.m.Y',AppointmentsDay::getDateWithFreeTime($this->doctor_id,$this->start_date));
        $this->buttons[] = [
            'role_available' => $this->allRoles,
            'text' => Html::encode('Свободное время '.$freeTimeDate),
            'url' => [
                $this->url,
                'start_date' => $freeTimeDate,
            ],
            'options' => [
                'class' => 'btn btn-xs btn-info',
                'title' => 'Свободное время',

            ]
        ];

    }
}