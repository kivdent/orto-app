<?php

namespace common\modules\api\controllers;

use common\modules\api\models\UserSearch;
use common\modules\userInterface\models\UserInterface;
use Yii;

class UserController extends \yii\rest\ActiveController
{
    public $modelClass = '\common\modules\api\models\User';

//    public function actions()
//    {
//        $actions = parent::actions();
//        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
//        return $actions;
//    }
//    public function prepareDataProvider()
//    {
//        $searchDiagnosis=new UserSearch;
//        //UserInterface::getVar(Yii::$app->request->queryParams);
//        return $searchDiagnosis->search(\Yii::$app->request->queryParams);
//    }
}