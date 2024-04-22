<?php

namespace common\modules\patient\controllers;

use common\modules\notifier\models\Sms;
use yii\data\ActiveDataProvider;

class NotifierController extends \yii\web\Controller
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
        $dataProvider = new ActiveDataProvider([
            'query' => Sms::find()->orderBy('created_at DESC')->where(['patient_id'=>$patient_id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,]);

    }
}