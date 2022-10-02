<?php


namespace common\modules\salary\models;


class SalaryCardType extends \common\models\SalaryCardType
//1', 'Percentage of revenue'
//2', payment at the rate
//3', 'Hourly pay'

{
    const TYPE_PERCENTAGE = 1;
    const TYPE_FIXED = 2;
    const TYPE_HOURLY = 3;
    const TYPE_PERCENTAGE_FULL = 4;
    const TYPE_PERCENTAGE_INCOME = 5;


    public $type_list = [
        self::TYPE_PERCENTAGE => 'Процент от баллов за манипуляции',
        self::TYPE_HOURLY => 'Почасовая оплата',
        self::TYPE_FIXED => 'Фиксированная ставка',
        self::TYPE_PERCENTAGE_FULL => 'Полная оплата',
        self::TYPE_PERCENTAGE_INCOME => 'Процент от выручки',
    ];
    public static function getTypeList(){
        $type_list = [
            self::TYPE_PERCENTAGE => 'Процент от баллов за манипуляции',
            self::TYPE_HOURLY => 'Почасовая оплата',
            self::TYPE_FIXED => 'Фиксированная ставка',
            self::TYPE_PERCENTAGE_FULL => 'Полная оплата',
            self::TYPE_PERCENTAGE_INCOME => 'Процент от выручки',
        ];
        return $type_list;
    }
}