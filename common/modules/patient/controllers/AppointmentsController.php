<?php

namespace common\modules\patient\controllers;

use common\modules\schedule\models\Appointment;
use yii\helpers\ArrayHelper;

class AppointmentsController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $this->layout = '@frontend/views/layouts/light';
        return true; // or false to not run the action
    }
    public function actionIndex($patient_id)
    {
        $appoitments=Appointment::getSortedByDate($patient_id);
        return $this->render('index',[
            'appoitments'=> $appoitments
        ]);
    }

}
