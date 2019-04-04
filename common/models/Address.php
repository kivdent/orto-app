<?php

/*
 *Объект адреса
 */
namespace common\models;

use common\interfaces\AddressInterface;

/**
 * Description of Address
 *
 * @author kivdent
 */
abstract class Address implements AddressInterface{
   /**
     * @return integer индекс
     */
   abstract public function getPostcode();

    /**
     * @return string название города
     */
   abstract public function getCity();

    /**
     * @return  string название улицы
     */
   abstract public function getStreet();
    /**
     * @return  string номер дома
     */
   abstract public function getHouse();
    /**
     * @return  string квартиры
     */
   abstract public function getApartment ();
   
}
