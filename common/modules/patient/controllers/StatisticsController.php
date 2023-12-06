<?php

namespace common\modules\patient\controllers;

use common\modules\patient\models\Statistics;
use common\modules\userInterface\models\UserInterface;

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
    public function actionPrintAkt($patient_id,$year)
    {

        $this->layout = '@frontend/views/layouts/print';
        $statistics=new Statistics($patient_id);
        $invoices=$statistics->getYearInvoices()[$year];

        return $this->render('print-akt',[
            'patient_id'=>$patient_id,
            'statistics'=>$statistics,
            'invoices'=>$invoices
        ]);
    }

}
