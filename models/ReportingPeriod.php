<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reportingPeriod
 * Класс описывает данные отчетного периода
 *
 * @author kivde
 */
class ReportingPeriod {

    public $id;
    public $start;
    public $end;
    public $uet;
    /*
     * В конструкторе инициализирется
     */
   
    public function __construct($id = NULL) {
        $db = Db::getConnection();

        $query = ($id == NULL) ? ' SELECT `id`,`nach` , `okonch`,`uet`
                            FROM `fin-per` 
                            ORDER BY `id` DESC
                            LIMIT 1' :
                           'SELECT `id`,`nach` , `okonch`,`uet`
                           FROM `fin-per` 
                           WHERE `id`=' . $id;



        $result = $db->query($query);
        $row = $result->fetch();
        //`id`, `nach`, `okonch`, `uet`
        $this->id=$row['id'];
        $this->start= DateTime::createFromFormat('Y-m-d', $row['nach']);
        $this->end=DateTime::createFromFormat('Y-m-d', $row['okonch']);
        $this->uet=$row['uet'];
        
    }
    
    
    /*
     * Установка нового периода
     */
    public static function setReportingPeriod() {
        
    }
    /*
     * Изменение  периода
     */
    public static function changeReportingPeriod($id=NULL) {


    }

}
