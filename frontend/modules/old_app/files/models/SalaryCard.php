<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SalaryCard
 *
 * @author kivdent
 */
require_once 'Workers.php';
class SalaryCard extends Workers {

    public $stavka; //       `zarp_card`.`stavka`,
    public $salaryCardId; // `zarp_card`.`id` as zc_id,
    public $percentSheme; //`proc_sh`.`id` as pc_id,
    public $incomeTax; //`zarp_card`.`pn` Подоходный налог
    public $sumFromPricelists;

    public static function getSalaryCardList() {
       
       $db=Db::getConnection();
       $query='SELECT 
                `sotr`.`id`, 
                `sotr`.`surname`, 
                `sotr`.`name`, 
                `sotr`.`otch`,
                `sotr`.`dolzh`, 
                `zarp_card`.`stavka`,
                `zarp_card`.`id` as zc_id,
                `proc_sh`.`id` as pc_id,
                `zarp_card`.`pn`
                FROM sotr,zarp_card,proc_sh
                WHERE (
                (`proc_sh`.`id`=`zarp_card`.`ps`) AND 
                (`zarp_card`.`type`=1) AND
                (`sotr`.`id`=`zarp_card`.`sotr`) 
                )';
       
       $result= $db->query($query);
        while ($row = $result->fetch()) {
           $salaryCardList[$row['id']]=new SalaryCard;
           $salaryCardList[$row['id']]->id=$row['id'];//`sotr`.`id`, 
           $salaryCardList[$row['id']]->surname=$row['surname'];///                `sotr`.`surname`, 
           $salaryCardList[$row['id']]->name=$row['name'];///                `sotr`.`name`, 
           $salaryCardList[$row['id']]->patronymic=$row['otch'];///                `sotr`.`otch`,
           $salaryCardList[$row['id']]->position=$row['dolzh'];///                `sotr`.`dolzh`, 
           $salaryCardList[$row['id']]->stavka=$row['stavka'];///                `zarp_card`.`stavka`,
           $salaryCardList[$row['id']]->salaryCardId=$row['zc_id'];///                `zarp_card`.`id` as zc_id,
           $salaryCardList[$row['id']]->percentSheme=$row['pc_id'];//                `proc_sh`.`id` as pc_id,
           $salaryCardList[$row['id']]->incomeTax=$row['pn'];///                `zarp_card`.`pn`
           $salaryCardList[$row['id']]->sumFromPricelists=array();///                `zarp_card`.`pn`
            
        }
        return $salaryCardList;
    }
  public function addToDb() {
        
    }
    public function changeInDb() {
        
    }
     public function deleteFromDb() {
        
    }
}
