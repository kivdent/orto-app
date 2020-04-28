<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\abstractClasses;

use Yii;
use common\interfaces\WorkModuleInterface;
use yii\base\Module;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * Description of WorkModule
 *
 * @author kivdent
 */
abstract class WorkModule extends Module implements WorkModuleInterface
{

    const IS_WORK_MODULE = true;

    public $moduleName = "";

    /**
     *
     * @param type $roleName Название роли пользователя
     * @return array ['label'=>'route']
     */
    public function getMenuItems()
    {
        $menuItems = isset($this->params['menuItems']) ? $this->params['menuItems'] : [];
        return $menuItems;
    }

    /**
     * Вовращает название модуля в человекопонятном формате
     * @return string
     */
    public function getModuleLabel()
    {


        return isset($this->moduleName)?$this->moduleName:"Не указано имя";

    }

    public function getEntity($entity)
    {
        $entitieClass = $this->getEntitysClass($entity);
        $entiesInsatance = new $entitieClass;
        return $entiesInsatance;
    }

    public function getEntitysClass($entity)
    {
        if (isset($this->params['entities'][$entity])) {
            return $this->params['entities'][$entity];
        } else {
            throw new NotFoundHttpException("Не нйден класс для работы с $entity");
        }
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->user->isGuest){

            Yii::$app->controller->redirect(['/site/login']);
            return false;
        }
        return true;
    }

}
