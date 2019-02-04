<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Обработка финасовых отчйтов
 *
 * @author kivde
 */
require_once 'PriceListTables.php';
require_once 'PriceList.php';

class FinancialReport {

    public $workersId;
    public $startDate;
    public $endDate;
    public $reportTable;
    public $summ = 0;
    public $summCoef = 0;
    public $uet; //uet из текущего периода

    public function __construct($workersId = 'all', $startDate = 'curr', $endDate = 'curr') {//$workersId массив с id сотрудников,'all' для всех
        $reportingPeriod = new ReportingPeriod();
        $this->workersId = $workersId;
        $this->uet = $reportingPeriod->uet;

        if ($startDate == 'curr') {

            $this->startDate = $reportingPeriod->start;
            $this->endDate = $reportingPeriod->end;
        } else {
            $this->startDate = $startDate;
            $this->endDate = $endDate;
        }
    }

    public function getallPayment() {//*allPayment-Все оплаты за период
    }

    public function getallInvoise() {   //  *          allInvoise-Все выписанные чеки период;
    }

    public function getclosedInvoice() {  //   *          closedInvoice Закрытые чеки за период;
        $mysqlTablesPriceList = PriceListTables::getTableOfPriclists(); //MySql Таблицы прайлистов , считая архивные

        $sqTables = include 'components/tables.php';
        $i = 1;
        foreach ($mysqlTablesPriceList as $priceList) {//Цикл по таблицам всех манипуляций 
            foreach ($sqTables as $table => $value) {//цикл по таблицам различных чеков
                $manip = 'manip' . $priceList['addition'];



                $query = "SELECT
                                    MAX(last_payment_date) AS last_payment_date,
                                    MAX(payment_type_name) AS payment_type_name,
                                    ROUND(SUM(manip_table.`koef` * count_manip),2) AS invoice_summ_coef,
                                    invoice_for_payment
                                FROM
                                     `" . $manip . "` AS manip_table
                                INNER JOIN(
                                


                                    SELECT
                                        manip_in_invoice_table.`kolvo` AS count_manip,
                                        manip_in_invoice_table.`manip`,
                                        last_payment_date,
                                        payment_type_name,
                                        invoice_for_payment
                                    FROM
                                         `" . $value['invoiceItems'] . "` AS manip_in_invoice_table
                                    INNER JOIN(
                                    

                                        SELECT
                                            MAX(payment_table.`date`) AS last_payment_date,
                                            MAX(payment_type.`vid`) AS payment_type_name,
                                            payment_table.`dnev` AS invoice_for_payment
                                       FROM
                                            `oplata` AS payment_table
                                        INNER JOIN `opl_vid` AS payment_type
                                        ON
                                            payment_type.`id` = payment_table.`VidOpl`
                                        INNER JOIN(
                                        

                                            SELECT
                                                invoice_table.`id` AS invoice_id
                                            FROM
                                                `" . $table . "` AS invoice_table
                                             WHERE(";
                if (!empty($value['addition'])) {
                    $query .= "(invoice_table." . $value['addition'];
                }
                $query .= "(invoice_table.`vrach` = " . $this->workersId . ") "
                        . "AND(invoice_table.`date` >= '" . $priceList['start']->format('Y-m-d') . "') "
                        . "AND(invoice_table.`date` <='" . $priceList['end']->format('Y-m-d') . "')  AND(
                                                        invoice_table.`summ_k_opl` = invoice_table.`summ_vnes`
                                                    )
                                                )
                                        ) AS invoice
                                    ON
                                        invoice.invoice_id = payment_table.`dnev`
                                        

                                    WHERE
                                        (
                                            (
                                                payment_table.`date` >= '" . $this->startDate->format('Y-m-d') . "'
                                            ) AND(
                                                payment_table.`date` <=  '" . $this->endDate->format('Y-m-d') . "'
                                            )
                                        )
                                    GROUP BY
                                        payment_table.`dnev`
                                    ) AS payment
                                ON
                                    payment.invoice_for_payment = manip_in_invoice_table.`" . $value['compl'] . "`
                                        


                                ) AS manip_in_invoice
                                ON
                                    manip_table.`id` = manip_in_invoice.`manip`
                                GROUP BY
                                   invoice_for_payment";



                $query = "SELECT
                                    MAX(worker_id) AS worker_id,
                                    MAX(worker_name) AS worker_name,
                                    MAX(invoice_id) AS invoice_id,
                                    MAX(invoce_date) AS invoice_date,
                                    MAX(patient_id) AS patient_id,
                                    MAX(patient_name) AS patient_name,
                                    MAX(last_payment_date) AS last_payment_date,
                                    MAX(payment_type_name) AS payment_type_name,
                                    ROUND(SUM(manip_table.`koef` * count_manip),2) AS invoice_summ_coef
                                FROM
                                     `" . $manip . "` AS manip_table
                                INNER JOIN(
                                    SELECT
                                        manip_in_invoice_table.`kolvo` AS count_manip,
                                        manip_in_invoice_table.`manip`,
                                        worker_id,
                                        worker_name,
                                        invoice_id,
                                        invoce_date,
                                        patient_id,
                                        patient_name,
                                        last_payment_date,
                                        payment_type_name
                                    FROM
                                         `" . $value['invoiceItems'] . "` AS manip_in_invoice_table
                                    INNER JOIN(
                                        SELECT
                                            MAX(payment_table.`date`) AS last_payment_date,
                                            MAX(payment_type.`vid`) AS payment_type_name,
                                            payment_table.`dnev` AS invoice_for_payment,
                                            worker_id,
                                            worker_name,
                                            invoice_id,
                                            invoce_date,
                                            patient_id,
                                            patient_name
                                        FROM
                                            `oplata` AS payment_table
                                        INNER JOIN `opl_vid` AS payment_type
                                        ON
                                            payment_type.`id` = payment_table.`VidOpl`
                                        INNER JOIN(
                                            SELECT
                                                invoice_table.`vrach` AS worker_id,
                                                CONCAT_WS(
                                                    ' ',
                                                    `sotr`.`surname`,
                                                    `sotr`.`name`,
                                                    `sotr`.`otch`
                                                ) AS worker_name,
                                                invoice_table.`id` AS invoice_id,
                                                invoice_table.`date` AS invoce_date,
                                                invoice_table.`pat` AS patient_id,
                                                CONCAT_WS(
                                                    ' ',
                                                    `klinikpat`.`surname`,
                                                    `klinikpat`.`name`,
                                                    `klinikpat`.`otch`
                                                ) AS patient_name
                                            FROM
                                                `" . $table . "` AS invoice_table,
                                                `sotr`,
                                                `klinikpat`
                                            WHERE(";
                if (!empty($value['addition'])) {
                    $query .= "(invoice_table." . $value['addition'];
                }
                $query .= "(invoice_table.`vrach` = " . $this->workersId . ") "
                        . "AND(invoice_table.`date` >= '" . $priceList['start']->format('Y-m-d') . "') "
                        . "AND(invoice_table.`date` <='" . $priceList['end']->format('Y-m-d') . "')  AND(
                                                        invoice_table.`summ_k_opl` = invoice_table.`summ_vnes`
                                                    ) AND(`sotr`.`id` = invoice_table.`vrach`) AND(
                                                        `klinikpat`.`id` = invoice_table.`pat`
                                                    )
                                                )
                                        ) AS invoice
                                    ON
                                        invoice.invoice_id = payment_table.`dnev`
                                    WHERE
                                        (
                                            (
                                                payment_table.`date` >= '" . $this->startDate->format('Y-m-d') . "'
                                            ) AND(
                                                payment_table.`date` <=  '" . $this->endDate->format('Y-m-d') . "'
                                            )
                                        )
                                    GROUP BY
                                        payment_table.`dnev`
                                    ) AS payment
                                ON
                                    payment.invoice_for_payment = manip_in_invoice_table.`" . $value['compl'] . "`
                                ) AS manip_in_invoice
                                ON
                                    manip_table.`id` = manip_in_invoice.`manip`
                                GROUP BY
                                    invoice_id";



                $result = Db::sqlQuery($query, '0');


                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $this->reportTable[$i] = $row;
                    $this->reportTable[$i]['invoice_summ'] = $row['invoice_summ_coef'] * $this->uet;
                    $this->summCoef += $row['invoice_summ_coef'];
                    $this->summ += $row['invoice_summ_coef'] * $this->uet;
                    $i++;
                }
            }
        }


        //Внесение сумм оплат за ортодонтию по схемам

        $query = "SELECT
                                  MAX(`sotr`.`id`) AS worker_id,
                                MAX(`schet_orto`.`id`) AS invoice_id,
                                MAX(`schet_orto`.`date`) AS invoice_date,
                                MAX(`schet_orto`.`pat`) AS patient_id,
                                MAX(`oplata`.`date`) AS last_payment_date,
                                MAX(`opl_vid`.`id`) AS payment_type_name,
                                CONCAT_WS(
                                    ' ',
                                    `klinikpat`.`surname`,
                                    `klinikpat`.`name`,
                                    `klinikpat`.`otch`
                                ) AS patient_name,
                                CONCAT_WS(
                                    ' ',
                                    `sotr`.`surname`,
                                    `sotr`.`name`,
                                    `sotr`.`otch`
                                ) AS worker_name,
                                SUM(`oplata`.`vnes`) AS invoice_summ
                        FROM
                           `oplata`,
                        `schet_orto`,
                        `sotr`,
                        `klinikpat`,
                        `opl_vid`
                        WHERE
                            (
                            (`klinikpat`.`id` = `schet_orto`.`pat`) AND
        (`sotr`.`id` = `schet_orto`.`vrach`) AND
        (`opl_vid`.`id` = `oplata`.`VidOpl`) AND
                                (`schet_orto`.`vrach` = " . $this->workersId . ") 
                                AND(
                                                `oplata`.`date` >= '" . $this->startDate->format('Y-m-d') . "'
                                            ) AND(
                                                `oplata`.`date` <=  '" . $this->endDate->format('Y-m-d') . "'
                                            )
                                AND(`oplata`.`dnev` = `schet_orto`.`id`) 
                                AND(`schet_orto`.`sh_id` <> 0) AND(`oplata`.`type` = 3) 
                                AND(`schet_orto`.`summ_k_opl` = `schet_orto`.`summ_vnes`)
                               
                            ) 
                            group by `oplata`.`dnev`";
        $result = Db::sqlQuery($query, '0');
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $this->reportTable[$i] = $row;
            $this->reportTable[$i]['invoice_summ_coef'] = 0;

            $this->summ += $row['invoice_summ'];
            $i++;
        }
    }

}
