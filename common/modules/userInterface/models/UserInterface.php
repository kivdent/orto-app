<?php

/*
 * Генерирование интерфейса пользователя
 * 
 */

namespace common\modules\userInterface\models;

use frontend\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use common\modules\userInterface\helpers\FormatHelper;

/**
 * Description of UserInterface
 *
 * @author kivdent
 */
class UserInterface
{

    const DEFAULT_ROUTE = '/old_app/pat_tooday.php';
    const DEFAULT_MENU_ITEM = ['label' => 'Главная', 'url' => '/'];

    public $user_id;
    public $employe_id;
    public $user_full_name;
    public $menuItems;
    public $roleName;
    public $params = [];

    /**
     *
     * @param int $user_id
     *
     */
    public function __construct()
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $this->user_id = $user_id;
            $user = User::findOne($user_id);
            $this->user_full_name = $user->employe->fullName;
            $this->employe_id = $user->employe->id;
            $this->roleName = $this->getRoleName($user_id);
            $this->menuItems = $this->getMenuItems();
        }
    }

    /**
     *
     * @param int $user_id
     *
     */
    public function setAtrributes()
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $this->user_id = $user_id;
            $user = User::findOne($user_id);
            $this->user_full_name = $user->employe->fullName;
            $this->employe_id = $user->employe->id;
            $this->roleName = $this->getRoleName($user_id);
            $this->menuItems = $this->getMenuItems();
        }
    }

    /**
     *
     * @param $user_id id пользователя
     *
     * @return string role name для ползователя с $user_id
     */
    public static function getRoleName(int $user_id)
    {
        $role = ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($user_id), 'name', false);
        return $role[0];
    }

    /**
     *
     *
     *
     * @return string интерфейс который реализуют рабоче модули.
     */
    public function getWorkModuleInterface()
    {
        $module = Yii::$app->getModule('userInterface');
        return $module->params['workModuleInterface'];
    }

    /**
     *
     * @param $user_id id пользователя
     *
     * @return string маршрут для ползователя с $user_id
     */
    public static function getDefaultRoute(int $user_id)
    {
        $role = self::getRoleName($user_id);
        $module = Yii::$app->getModule('userInterface');
        $route = isset($module->params['defaultRoutes'][$role]) ? $module->params['defaultRoutes'][$role] : self::DEFAULT_ROUTE;
        return $route;
    }

    /**
     * Формирует массив с элеменатми меню для пользователя из модулей
     *
     *
     * @return array
     */
    public function getMenuItems()
    {
        $menuItems = [];
        $roleName = $this->roleName;
        $modules = $this->getWorkModules();
        foreach ($modules as $moduleName => $module) {
            $moduleMenuItems = $module->getMenuItems();
            if (!empty($moduleMenuItems)) {
               $hasMenuItemsForUser=false;
                $subMenuItems=[];
                foreach ($moduleMenuItems as $moduleMenuItem) {
                    if (ArrayHelper::isIn($roleName, $moduleMenuItem['roles'])) {
                        $subMenuItems[] = [
                            'label' => $moduleMenuItem['label'],
                            'url' => $moduleMenuItem['url'],

                        ];
                        $hasMenuItemsForUser=true;
                    }
                }
                if($hasMenuItemsForUser) {
                    $menuItems[] = [
                        'label' => $module->getModuleLabel(),
                        'url' => '#',
                        'options' => ['class' => 'active'],];

                    $menuItems=array_merge($menuItems,$subMenuItems);
                }

            };

        }


        return $menuItems;
    }

    /**
     * Состовляет список рабочих модулей
     * @return array
     */
    public function getWorkModules()
    {
        $modules = [];
        $workModuleInterface = $this->getWorkModuleInterface();
        foreach (array_keys(Yii::$app->getModules()) as $moduleName) {
            $module = Yii::$app->getModule($moduleName);
            if (($module instanceof $workModuleInterface)) {
                $modules [] = $module;
            }
        }
        return $modules;
    }

    public function getWidget($widgetName)
    {
        $module = Yii::$app->getModule('userInterface');
        $widget = isset($module->params['widgets'][$widgetName]) ? $module->params['widgets'][$widgetName] : "Виджет $widgetName не найден";
        return $widget;
    }

    public function getNameDayWeek($numberDayWeek)
    {
        return FormatHelper::getNameDayWeek($numberDayWeek);
    }

    public function hasModuleMenu()
    {
        $module = Yii::$app->controller->module;
        $result = (Isset($module->params['moduleMenu'])) ? true : false;
        return $result;
    }

    public function renderModuleMenu()
    {
        $module = Yii::$app->controller->module;
        $result = (Isset($module->params['moduleMenu'])) ? $module->params['moduleMenu']['file'] : false;
        return $result;
    }

}
