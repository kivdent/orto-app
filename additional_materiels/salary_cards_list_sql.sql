/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  kivde
 * Created: 27.01.2019
*Запросс суммирует коэффициенты из чеков полностью оплаченных в текущем месяце, группируя их по прейскурантам

 */

SELECT
    `manip`.`preysk`,
    ROUND(
        SUM(
            `manip`.`koef` * manip_in_month.manip_count
        ),
        2
    ) AS summ
FROM
    `manip`
INNER JOIN(
    SELECT
        `manip_pr`.`kolvo` AS manip_count,
        `manip_pr`.`manip` AS manip_id
    FROM
        `manip_pr`
    INNER JOIN(
        SELECT
            `dnev`.`id` AS dnev_id
        FROM
            `dnev`
        INNER JOIN(
            SELECT
                `dnev`
            FROM
                `oplata`
            WHERE
                (
                    (`oplata`.`date` >= '2018-12-01') AND(`oplata`.`date` <= '2018-12-31') AND(`oplata`.`type` = 1)
                )
            GROUP BY
                `dnev`
        ) AS oplata_in_month
    ON
        `dnev`.`id` = oplata_in_month.`dnev`
    WHERE
        (
            (`dnev`.`vrach` = 1) AND(`dnev`.`date` >= '2018-05-12') AND(`dnev`.`date` < '2019-01-27') AND(
                `dnev`.`summ_k_opl` = `dnev`.`summ_vnes`
            )
        )
    ) AS dnev_in_month
ON
    `manip_pr`.`dnev` = dnev_in_month.dnev_id
) AS manip_in_month
ON
    `manip`.`id` = manip_in_month.manip_id
GROUP BY
    `manip`.`preysk`
