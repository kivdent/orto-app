<?php

/*
  Интерфейч для функцональных модулей программмы
 */

namespace common\interfaces;

/**
 *
 * @author kivdent
 */
interface ModuleInterface {
    /**
     * 
     * @param type $roleName имя роли пользователя
     * @return array ['label'=>'route']
     */
    public function getMenuItemsByRole($roleName);
    
}
