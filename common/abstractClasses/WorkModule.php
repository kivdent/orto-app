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

/**
 * Description of WorkModule
 *
 * @author kivdent
 */

abstract class WorkModule extends Module implements WorkModuleInterface {
    
    const IS_WORK_MODULE=true;

    public $moduleName = "";
    public $entitys=[];//сущности используемые в модели;

  

    /**
     * 
     * @param type $roleName Название роли пользователя
     * @return array ['label'=>'route']
     */
    public function getMenuItems() {
         $menuItems=isset($this->params['menuItems'])? $this->params['menuItems'] :[];
        return  $menuItems;
    }

    /**
     * Вовращает название модуля в человекопонятном формате
     * @return string
     */
    public function getModuleLabel() {
        return $this->moduleName;
    }
    
}
