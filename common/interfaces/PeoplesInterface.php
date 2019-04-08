<?php

/*
 * Интерфейс сущностей людей
 */

namespace common\interfaces;

use common\abstractClasses\Address;

/**
 *
 * @author kivde
 */
interface PeoplesInterface {


    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    

    /**
     * @return string воpвращает имя 
     */
    public function getId();
        /**
     * @return string воpвращает Фамилию 
     */
    public function getSurname();
     /**
     * @return string воpвращает Имя 
     */
       public function getName();
     /**
     * @return string воpвращает Отчество 
     */
    public function getPatronymic();
      /**
     * @return string воpвращает полное имя 
     */
    public function getFullName();
    /**
     * @return datetime воpвращает дату рождения 
     */
    public function getDateOfBirth();
    /**
     * @return Address воpвращает адресс 
     */
    public function getAddres() : Address;
    /**
     * @return string воpвращает пол 
     */
    public function getGender();
    
    /**
     * @return string воpвращает телефонный номер 
     */
    public function getPhoneNumber();
}
