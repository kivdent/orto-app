<?php

/*
 * Генерирование интерфейса пользователя
 * 
 */

namespace frontend\modules\userInterface\models;

use frontend\models\User;
use Yii;
use yii\helpers\ArrayHelper;
/**
 * Description of UserInterface
 *
 * @author kivdent
 */
class UserInterface {
     const DEFAULT_ROUTE='/old_app/pat_tooday.php';
     
     public $user_id;
     public $user_full_name;


     /**
      * 
      * @param int $user_id
      * 
      */
     
     public function __construct(int $user_id) {
         $this->user_id=$user_id;
         $user= User::findOne($user_id);
         $this->user_full_name=$user->employe->fullName;
     }
    /**
     * 
     * @param $user_id id пользователя
     * 
     * @return string role name для ползователя с $user_id
     */
    private static function getRoleName(int $user_id) {
        return ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($user_id), 'name', false);
    }

    /**
     * 
     * @param $user_id id пользователя
     * 
     * @return string маршрут для ползователя с $user_id
     */
    public static function getDefaultRoute(int $user_id) {
        $role = self::getRoleName($user_id);
        $module = Yii::$app->getModule('userInterface');
        $route = isset($module->params['defaultRoutes'][$role[0]])?$module->params['defaultRoutes'][$role[0]]:self::DEFAULT_ROUTE;
        return $route;
    }
/**
     * Формирует массив с элеменатми меню для пользователя из модулей
     * @param $user_id id пользователя
     * 
     * @return array  
     */
    public function getMenuItems() {
        $role = self::getRoleName($this->user_id);
        $module = Yii::$app->getModule('old_app');
        $menuItems=isset($module->params['menuItems'][$role[0]])?$module->params['menuItems'][$role[0]]:['label'=>'login','url'=>'#'];
        return $menuItems;
    }

}
