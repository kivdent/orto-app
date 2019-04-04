<?php

/*
 *Интерфейс предосавления информации о сотруднике
 */

namespace common\interfaces;

use common\interfaces\PeoplesInterface;
/**
 *
 * @author kivdent
 */
interface EmployeesInterface extends PeoplesInterface{
    
    /**
     * @return integer идентификатор должности
     */
    public function getPosition();
    
     /**
     * @return integer название должности
     */
    public function getPositionName();
}
