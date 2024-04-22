<?php

namespace common\modules\notifier\controllers;

use common\modules\notifier\models\Wazzup;
use common\modules\userInterface\models\UserInterface;

class WazzupController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSettings()
    {
        return $this->render('settings');
    }

    public function actionAddUser()
    {
        $results=[];
//        $result = Wazzup::sendGet();
//        $results[]=json_decode($result);
////        $result=json_decode(Wazzup::addUser());
////        $results[]=$result;
//        $result=json_decode(Wazzup::sendPost());
////        UserInterface::getVar($result,false);
//        $results[]=$result;
        return $this->render('index', [
                'result' => $results
            ]
        );
    }

}
