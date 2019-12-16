<?php


namespace console\controllers;
use common\models\User;
use Yii;
use yii\console\Controller;
use yii\db\Query;

class OrtomigrationController extends Controller
{
    public $roles = [
        '1'=>'admin',
        '2'=>'therapist',
        '3'=>'orthopedist',
        '4'=>'orthodontist',
        '5'=>'recorder',
        '6'=>'accountant',
        '7'=>'senior_nurse',
        '13'=>'director',
        '14'=>'radiologist',
        '17'=>'surgeon',
    ];

    public function actionUser()
    {

        $auth = Yii::$app->authManager;
        foreach ($this->getOldUsers() as $oldUser){

            print_r($this->roles[$oldUser['UsarPrava']]);
            $userRole=$auth->getRole($this->roles[$oldUser['UsarPrava']]);
            print_r($userRole);
            //die();
            $user = new User();
            $user->username = $oldUser['login'];
            $user->email = "default@site.com";
            $user->setPassword($oldUser['pass']);
            $user->generateAuthKey();
            $user->employe_id = $oldUser['sotr'];
            $user->save(false);
            $userRole=$auth->getRole($this->roles[$oldUser['UsarPrava']]);
            $auth->assign($userRole, $user->id);
            echo "Пользователь ".$user->username." сохранён, роль: ".$this->roles[$oldUser['UsarPrava']];
        }
    }
    private function getOldUsers()
    {

        $query=new Query();
        $rows=$query->select('login,pass,sotr,UsarPrava')
            ->from('users')
            ->where(['<>','login','admin'])
            ->andWhere(['>','UsarPrava','0'])
            ->andWhere(['>','sotr','0'])
            ->all();
        return $rows;
    }
}