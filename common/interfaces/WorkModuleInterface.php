<?php

/*
  Интерфейч для функцональных модулей программмы
 */

namespace common\interfaces;

/**
 *
 * @author kivdent
 */
interface WorkModuleInterface {

    /**
     * 
     * @param type $roleName имя роли пользователя
     * @return array ['label'=>'route']
     */
    public function getMenuItems();
    
    /**
     * Вовращает название модуля в человекопонятном формате
     */
     public function getModuleLabel();
     /**
      * Получение сущности
      * @param object $entitie
      */
      public function getEntitie($entitie);
    
}
