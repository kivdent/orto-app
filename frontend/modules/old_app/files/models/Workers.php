<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Workers
 *
 * @author kivde
 */
require Yii::$app->params['old_app_mvc_path'].'models/Peoples.php';
class Workers extends Peoples {
    public $position;//Должность
    public function addToDb() {
        
    }
    public function changeInDb() {
        
    }
     public function deleteFromDb() {
        
    }
    
}
