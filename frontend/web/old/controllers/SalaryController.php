<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controllerSalary
 *
 * @author kivde
 */
require_once 'models/ReportingPeriod.php';
require_once 'models/Salary.php';
require_once 'models/PriceList.php';

class SalaryController {
    /*
     * Получение отчетного периода
     */
    public $reportingPeriod;
    public $viewPath='';
   
    public function __construct($id=NULL) {
         $this->reportingPeriod= new ReportingPeriod($id);
         }
    
    
   
    
     public function showSalary($ReportingPeriod) {
        //$this->showReportingPeriodJumpMenu();
        //$this->showActions();
         $this->showSalaryByPercent();
         $summKorchemnaya= Salary::getSalarySummFromPaymentsByWorkerId('3', $this->reportingPeriod);
                 
         echo "<span class='head3'>Оплаты Корчемная Ольга Сергеевна:" . $summKorchemnaya . "</span><br />"; 
         
    }
    
    public function showActions(){
         echo  'Действия</br>';
    }

        public function showReportingPeriodJumpMenu($id=null) {
        $priceLists= PriceList::getListOfPriceLists();
        echo  'Прыгающее меню</br>';
    }
    /*
     * Оплата по процентам
     */
    public function showSalaryByPercent() {
        $salaryTable= Salary::getSalaryTableByPercent($this->reportingPeriod);
        
        require_once 'views/'.$this->viewPath.'SalaryByPercent.php';
    }
    
    
    
    
    /*
     * Зарплата по часам
     */
        public function showSalaryByHourlyPayment() {
        echo 'Оплата по часам</br>';
    }
    
    /*
     * Зарплата по ставке
     */
     public function showSalaryByWageRate() {
        echo 'Оплата по окладу</br>';
    }
}
