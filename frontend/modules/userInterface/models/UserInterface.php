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

    const DEFAULT_ROUTE = '/old_app/pat_tooday.php';
    const OLD_USER_PRAVA_VALUES = [
        'admin' => '1',
        'therapist' => '2',
        'orthopedist' => '3',
        'orthodontist' => '4',
        'recorder' => '5',
        'accountant' => '6',
        'senior nurse' => '7',
        'director' => '13',
        'radiologist' => '14',
        'surgeon' => '17',
    ];

    public $user_id;
     public $employe_id;
    public $user_full_name;
    public $old_user_prava;

    /**
     * 
     * @param int $user_id
     * 
     */
    public function __construct(int $user_id) {
        $this->user_id = $user_id;
        $user = User::findOne($user_id);
        $this->user_full_name = $user->employe->fullName;
        $this->employe_id=$user->employe->id;
        $this->old_user_prava= self::OLD_USER_PRAVA_VALUES[self::getRoleName($user_id)];
    }

    /**
     * 
     * @param $user_id id пользователя
     * 
     * @return string role name для ползователя с $user_id
     */
    private static function getRoleName(int $user_id) {
        $role=ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($user_id), 'name', false);
        return  $role[0];
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
        $route = isset($module->params['defaultRoutes'][$role]) ? $module->params['defaultRoutes'][$role] : self::DEFAULT_ROUTE;
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
        $menuItems = isset($module->params['menuItems'][$role]) ? $module->params['menuItems'][$role] : ['label' => 'login', 'url' => '#'];
        return $menuItems;
    }

}
