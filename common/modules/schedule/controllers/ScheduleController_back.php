<?php

namespace common\modules\schedule\controllers;

use common\modules\schedule\models\ScheduleManager;

class ScheduleControllerBack extends \yii\web\Controller
{
    public function actionIndex($start_date = 'now')
    {
        $start_date = strtotime($start_date);
        $scheduleManager = new ScheduleManager(['start_date' => $start_date]);
        return $this->render('index',[
          'scheduleManager'=>$scheduleManager,
        ]);
    }

}
