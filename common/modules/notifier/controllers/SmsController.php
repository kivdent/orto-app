<?php


namespace common\modules\notifier\controllers;


use common\modules\schedule\models\Appointment;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\components\SmsNotifier;

class SmsController extends Controller
{
    public function actionSendAppointmentNotification()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        return SmsNotifier::sendAppointmentNotification(Yii::$app->request->post('appointment'));
    }
}