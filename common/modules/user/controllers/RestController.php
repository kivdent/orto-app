<?php

namespace common\modules\user\controllers;


use common\modules\employee\models\Employee;
use common\modules\user\models\User;
use Yii;
use yii\web\Response;

class RestController extends \yii\web\Controller
{
    public function actionGetWazzupUsers()
    {
        $response = [];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $employes = array_column(Employee::find()
            ->where(['status' => Employee::STATUS_WORKED])
            ->andWhere(['dolzh' => Employee::POSITION_REGISTRATOR])
            ->asArray()
            ->all(), 'id');

        $users = User::find()
            ->where(['IN', 'employe_id', $employes])
            ->all();
        foreach ($users as $user) {
            $response[]=[
                'id'=>$user->id,
                'name'=>$user->employe->name.' '.$user->employe->surname,
            ];
        }
        return $response;
    }
}