<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FinancialReportController
 *
 * @author kivde
 */
require_once 'models/ReportingPeriod.php';
require_once 'models/FinancialReport.php';

class FinancialReportController {
    
    public $reportingPeriod;
    /*
     * type=allPayment-Все оплаты за период;
     *          allInvoise-Все выписанные чеки период;
     *          closedInvoice Закрытые чеки за период;
     * 
     * 
     */
    public function showFRWorkerInPeriod($type,$workersId,$startDate='curr',$stopDate='curr') {
            $finacialReport=new FinancialReport($workersId,$startDate,$stopDate);
            //$type='get'.$type;
            call_user_func(array($finacialReport,'get'.$type)); 
                       
           require_once ('views/FinancialReport_'.$type.'.php');
    }
}
