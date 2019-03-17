<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Peoples
 *
 * @author kivde
 */
abstract class Peoples {

    public $id;
    public $surname;
    public $name;
    public $patronymic;
    public $burthdate;

    abstract function addToDb();

    abstract public function changeInDb();

    abstract public function deleteFromDb();
}
