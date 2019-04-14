<?php

/*
 *@description Интерфейс адреса
 */

namespace common\interfaces;

/**
 *
 * @author kivdent
 */
interface AddressInterface extends EntitiesInterface{

    /**
     * @return integer индекс
     */
    public function getPostcode();

    /**
     * @return string название города
     */
    public function getCity();

    /**
     * @return  string название улицы
     */
    public function getStreet();
    /**
     * @return  string номер дома
     */
    public function getHouse();
    /**
     * @return  string квартиры
     */
    public function getApartment ();
}
