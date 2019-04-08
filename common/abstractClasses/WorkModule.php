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

/**
 * Description of WorkModule
 *
 * @author kivdent
 */
abstract class WorkModule extends Module implements WorkModuleInterface {

    const IS_WORK_MODULE = true;

    public $moduleName = "";

    /**
     * 
     * @param type $roleName Название роли пользователя
     * @return array ['label'=>'route']
     */
    public function getMenuItems() {
        $menuItems = isset($this->params['menuItems']) ? $this->params['menuItems'] : [];
        return $menuItems;
    }

    /**
     * Вовращает название модуля в человекопонятном формате
     * @return string
     */
    public function getModuleLabel() {
        return $this->moduleName;
    }

    public function getEntitie($entitie) {
        $entitieClass=$this->getEntitiesClass($entitie);
        $entiesInsatance=new $entitieClass;
        return $entiesInsatance;
    }

    private function getEntitiesClass($entitie) {
        if (isset($this->params['entities'][$entitie])) {
            return $this->params['entities'][$entitie];
        }else{
            throw new NotFoundHttpException('Не нйден класс для работы с {$entitie}');
        }
    }

}
