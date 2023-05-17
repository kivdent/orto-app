<?php

namespace common\modules\api\controllers;

use common\modules\api\models\DiagnosisSearch;

class DiagnosisController extends \yii\rest\ActiveController
{
    public $modelClass = '\common\modules\api\models\Diagnosis';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchDiagnosis=new DiagnosisSearch;
        return $searchDiagnosis->search(\Yii::$app->request->queryParams);
    }
}