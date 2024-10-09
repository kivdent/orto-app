<?php

namespace common\modules\statistics\controllers;

use common\modules\statistics\models\PatientStatistics;
use yii\web\Controller;

class PatientController extends Controller
{
    public function actionRedirect($start_date = PatientStatistics::CURRENT_MONTH,$duration_month=1){
        $patientStatistics=PatientStatistics::getForPeriod($start_date,$duration_month);
        return $this->render('redirect',[
            'patientStatistics'=>$patientStatistics
        ]);
    }

    public function actionTherapyToOrthodontics($start_date = PatientStatistics::CURRENT_MONTH,$duration_month=1){
        $patientStatistics=PatientStatistics::getForPeriod($start_date,$duration_month);
        return $this->render('therapy_to_orthodontics',[
            'patientStatistics'=>$patientStatistics
        ]);
    }
}