<?php

namespace common\modules\patient\controllers;

use common\modules\patient\models\Statistics;

class StatisticsController extends \yii\web\Controller
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
        $statistics=new Statistics($patient_id);
        return $this->render('index',[
            'statistics'=>$statistics
        ]);
    }

}
