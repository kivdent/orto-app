<?php

namespace common\modules\api\controllers;

use common\modules\api\models\OperationPricelistItemsComplianceSearch;
use common\modules\userInterface\models\UserInterface;

class OperationPricelistItemsComplianceController extends \yii\rest\ActiveController
{
    public $modelClass = "\common\modules\api\models\OperationPricelistItemsCompliance";
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }
    public function prepareDataProvider()
    {

        $searchDiagnosis=new OperationPricelistItemsComplianceSearch();
        return $searchDiagnosis->search(\Yii::$app->request->queryParams);
    }
}