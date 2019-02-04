/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  kivde
 * Created: 29.01.2019
 */
//Для метода closedInvoice Таблиц чеков полностью оплаченных в этом периоде
$query = "SELECT
                                    MAX(worker_id) AS worker_id,
                                    MAX(worker_name) AS worker_name,
                                    MAX(invoice_id) AS invoice_id,
                                    MAX(invoce_date) AS invoce_date,
                                    MAX(patient_id) AS patient_id,
                                    MAX(patient_name) AS patient_name,
                                    MAX(last_payment_date) AS last_payment_date,
                                    MAX(payment_type_name) ASpayment_type_name,
                                    ROUND(SUM(manip_table.`koef` * count_manip),2) AS invoice_summ
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
                                            payment_type.`vid` AS payment_type_name,
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
                                                if (!empty($value['addition']))   {
                                                    $query.="(invoice_table.".$value['addition'];
                                                            
                                                }
                                                   $query.= "(invoice_table.`vrach` = " .$this->workersId . ") "
                        . "AND(invoice_table.`date` >= '" . $priceList['start']->format('Y-m-d') . "') "
                        . "AND(invoice_table.`date` <'" . $priceList['end']->format('Y-m-d') . "')  AND(
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
                                        payment_table.`dnev`,
                                        payment_type.`vid`
                                    ) AS payment
                                ON
                                    payment.invoice_for_payment = manip_in_invoice_table.`" . $value['compl'] . "`
                                ) AS manip_in_invoice
                                ON
                                    manip_table.`id` = manip_in_invoice.`manip`
                                GROUP BY
                                    invoice_id";


//Сумма чеков полностью оплаченных в этом периоде сгруппированая по прейскурантам
SELECT
    manip_table.`preysk`,
     ROUND(SUM(manip_table.`koef` * count_manip),2) AS invoice_summ
FROM
    `manip` AS manip_table
INNER JOIN(
    SELECT
        manip_in_invoice_table.`kolvo` AS count_manip,
        manip_in_invoice_table.`manip`
    FROM
        `manip_pr` AS manip_in_invoice_table
    INNER JOIN(
        SELECT
            MAX(payment_table.`date`) AS last_payment_date,
            payment_type.`vid` AS payment_type_name,
            payment_table.`dnev` AS invoice_for_payment
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
                invoice_table.`pat` AS patient_id
            FROM
                `dnev` AS invoice_table,
                `sotr`
            WHERE
                (
                    (invoice_table.`vrach` = 1) AND(
                        invoice_table.`summ_k_opl` = invoice_table.`summ_vnes`
                    ) AND(`sotr`.`id` = invoice_table.`vrach`)
                )
        ) AS invoice
    ON
        invoice.invoice_id = payment_table.`dnev`
    WHERE
        (
            (
                payment_table.`date` >= '2019-01-01'
            ) AND(
                payment_table.`date` <= '2019-01-31'
            )
        )
    GROUP BY
        payment_table.`dnev`,
        payment_type.`vid`,
        payment_table.`dnev`
    ) AS payment
ON
    payment.invoice_for_payment = manip_in_invoice_table.`dnev`
) AS manip_in_invoice
ON
    manip_table.`id` = manip_in_invoice.`manip`
GROUP BY
    manip_table.`preysk`