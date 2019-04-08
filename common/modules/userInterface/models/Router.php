<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\userInterface\models;

use frontend\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Модель для формирования маршрутов по умолчанию для разных пользователей
 *
 * @author kivde
 */
class Router {
    const DEFAULT_ROUTE='/old_app?file=pat_tooday.php';
    /**
     * 
     * @param $user_id id пользователя
     * 
     * @return string role name для ползователя с $user_id
     */
    private static function getRole(int $user_id) {
        return ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($user_id), 'name', false);
    }

    /**
     * 
     * @param $user_id id пользователя
     * 
     * @return string маршрут для ползователя с $user_id
     */
    public static function getDefaultRoute(int $user_id) {
        $role = self::getRole($user_id);
        $module = Yii::$app->getModule('userInterface');
        $route = isset($module->params['defaultRoutes'][$role[0]])?$module->params['defaultRoutes'][$role[0]]:self::DEFAULT_ROUTE;
        return $route;
    }
/**
     * Формирует массив с элеменатми меню для пользователя
     * @param $user_id id пользователя
     * 
     * @return array  
     */
    public static function getMenuItems(int $user_id) {
        $role = self::getRole($user_id);
        $module = Yii::$app->getModule('old_app');
        $menuItems=isset($module->params['menuItems'][$role[0]])?$module->params['menuItems'][$role[0]]:['label'=>'login','url'=>'#'];
        return $menuItems;
    }

}
