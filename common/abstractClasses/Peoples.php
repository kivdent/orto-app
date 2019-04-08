<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\abstractClasses;
use common\interfaces\PeoplesInterface;

/**
 * Description of Peoples
 *
 * @author kivdent
 */
abstract class Peoples implements PeoplesInterface{
    
    /**
     * @return string воpвращает имя 
     */
   abstract public function getId();
        /**
     * @return string воpвращает Фамилию 
     */
   abstract public function getSurname();
    /**
     * @return string воpвращает Имя 
     */
       public function getName();
  
     /**
     * @return string воpвращает Отчество 
     */
   abstract public function getPatronymic();
      /**
     * @return string воpвращает полное имя 
     */
   public function getFullName(){
       return $this->getSurname()." ".$this->getName()." ".$this->getPatronymic();
   }
    /**
     * @return datetime воpвращает дату рождения 
     */
   abstract public function getDateOfBirth();
    /**
     * @return Address воpвращает адресс 
     */
   abstract public function getAddres() : Address;
    /**
     * @return string воpвращает пол 
     */
   abstract public function getGender();
    
    /**
     * @return string воpвращает телефонный номер 
     */
   abstract public function getPhoneNumber();
}


