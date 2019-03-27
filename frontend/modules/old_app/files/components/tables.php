<?php

//invoiceТаблица чеков
//invoiceItems таблица манипуляций
//compl Название столбца чека в таблице манипуляций
return array(
    'dnev' => array(
        'invoice' => "dnev",
        'invoiceItems' => "manip_pr",
        'compl' => "dnev",
        'paymentType'=>1,
        'addition'=>''
    ),
    'zaknar' => array(
        'invoice' => "zaknar",
        'invoiceItems' => "manip_zn",
        'compl' => "ZN",
        'paymentType'=>2,
        'addition'=>''
    ),
    'schet_orto' => array
        (
        'invoice' => "schet_orto",
        'invoiceItems' => "manip_sh_orto",
        'compl' => "SO",
        'paymentType'=>3,
        'addition'=>' `sh_id`=0) AND'
    )
);

