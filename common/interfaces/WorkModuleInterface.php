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
      * Получение объекта сущности
      * @param string $entitie
      */
      public function getEntity($entitie);
      /**
       *  Получение класса сущности
       * @param string $entitie
       */
     public function getEntitysClass($entitie);
}
