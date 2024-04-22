<?php

namespace common\modules\userInterface\controllers;

use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class RestController extends \yii\web\Controller
{
    public function actionGetCurrentUser()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = UserInterface::getCurrentUser();
//ArrayHelper::toArray(UserInterface::getCurrentUser());
        $response['id'] = $user->id;
        $response['name'] = $user->employe->name . ' ' . $user->employe->surname;
        return $response;
    }
}
