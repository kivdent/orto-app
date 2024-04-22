<?php

namespace common\modules\notifier\controllers;

use Yii;
use yii\web\Response;

class RestController extends \yii\web\Controller
{
    public function actionGetAppointment()
    {
        $response = [];

        Yii::$app->response->format = Response::FORMAT_JSON;

        $patient_id = Yii::$app->request->get('appointment_id');


    }
}