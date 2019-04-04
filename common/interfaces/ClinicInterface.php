<?php

/*
 * Интрефес представления информации о клинике
 * -Название
 * -Адрес
 * -Контактный телефон
 * -График работы
 * -Описание
 * -Реквизиты
 * -Рабочие места
 * -Подразделения 
 */

namespace common\interfaces;

/**
 *
 * @author kivde
 */
interface Clinic {

    /**
     * Название клиники@return string
     */
    public function getName();

    /**
     * Описание клиники@return string
     */
    public function getDescription();

    /**
     * Адрес клиники
     * @return array 
     */
    public function getAddres();

    /**
     * Расписание клиники
     * @return array 
     */
    public function getClinicSheudle();

    /**
     * Финансовые подразделения клиники
     * @return array 
     */
    public function getFinancialDivisions();
    
    /**
     * Рабочие места клиники
     * @return array 
     */
    public function getWorkplaces();
}
