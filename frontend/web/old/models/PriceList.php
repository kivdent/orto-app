<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pricelist Логика работы с прейскурантами
 *
 * @author kivde
 */
class PriceList {
    public $id;
    public $name;
    public $modules;
    
    
    /*
     * При создании объекта прайслист $modules список модулей в виде массива $array=('all','none','doctors','x-ray')в которых отображается прайс,
     *  $modules='all' показывает все прайсы беучета modules
     * 
     * 
     * 
     */
    public function __construct($id,$name,$modules=array('all')) {
        $this->id=$id;
        $this->name=$name;
        $this->modules=$modules;
    }

    
    
    /*
     * $modules='all' показывает все прайсы беучета modules
     */
    public static function getListOfPriceLists($modules=array('all')) {
        
        $query = $modules=='all' ? 'SELECT * FROM `preysk`' : "SELECT * FROM `preysk`WHERE `modules`='". serialize($modules)."'";
        $result=Db::sqlQuery ($query);
        
        while ($row = $result->fetch()) {
             $priceLists[$row['id']] = new PriceList($row['id'],$row['preysk'],unserialize($row['modules']));
            
             }
        
        return $priceLists;
    }

    public static function getPriceListById() {
        
    }

    public static function createPriceList() {
        
    }

    public static function changePricelist() {
        
    }
    /*
     * Копирует таблица с манипуляциями в таблицу manip_DD_MM_YYYY preysk_DD_MM_YYYY в 
     */
    public function copyToArchivePricelist() {
        
    }
}
