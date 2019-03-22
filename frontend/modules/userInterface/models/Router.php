<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\userInterface\models;

use frontend\models\User;
use Yii;
use yii\helpers\ArrayHelper;
/**
 * Модель для формирования маршрутов по умолчанию для разных пользователей
 *
 * @author kivde
 */
class Router {
    /**
     * 
     * @param $user_id id пользователя
     * 
     * @return string маршрут для роли $role
     */
    public static function getDefaultRoute(int $user_id) {
        $role= ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($user_id), 'name',false);
        //$role=Yii::$app->authManager->getRolesByUser($user_id);
        $module =Yii::$app->getModule('userInterface');
        $route=$module->params['defaultRoutes'][$role[0]];
        return $route;
    }
}
