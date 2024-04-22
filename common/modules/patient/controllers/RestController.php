<?php

namespace common\modules\patient\controllers;

use common\modules\patient\models\Patient;
use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\web\Response;

class RestController extends \yii\web\Controller
{
    public function actionGetPatientPhone()
    {
        $response = [];

        Yii::$app->response->format = Response::FORMAT_JSON;

        $patient_id = Yii::$app->request->get('patient_id');

        $patient=Patient::findOne($patient_id);


        //return ['phone'=>UserInterface::getNormalizedPhone($patient->MTel)];
        $phone = preg_replace("/[^0-9]/", '', $patient->MTel);
        $phone = '7' . substr($phone, 1, 10);
        return ['phone'=>$phone];
    }
}