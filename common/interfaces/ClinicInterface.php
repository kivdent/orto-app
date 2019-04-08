<?php

/*
 * Интрефейс представления информации о клинике
 * -Название
 * -Логотип
 * -Адрес
 * -Контактный телефон
 * -График работы
 * -Описание
 * -Реквизиты
 * -Рабочие места
 * -Подразделения 
 */

namespace common\interfaces;


use common\interfaces\EntitiesInterface;
/**
 *
 * @author kivdent
 */
interface ClinicInterface extends EntitiesInterface{

    /**
     * Название клиники
     * @return string
     */
    public function getName();

    /**
     * Описание клиники
     * @return string
     */
    public function getDescription();

    
    /**
     * Реквизиты клиники
     * @return string
     */
    public function getRequisites();

    /**
     * Адрес клиники
     * @return array 
     */
    public function getAddres();

    /**
     * Расписание клиники
     * @return array 
     */
    public function getSheudle();

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
     /**
     * Логотип
     * @return array 
     */
    public function getLogo();
}
