<?php


namespace common\modules\invoice\models;


class SchemeOrthodontics extends \common\models\SchemeOrthodontics
{
    public function attributeLabels()
    {
        return [
            'id' => 'Номер',
            'pat' => 'Пацинет',
            'sotr' => 'Врач',
            'date' => 'Дата создания',
            'per_lech' => 'Срок лечения',
            'summ' => 'Обшая сумма за лечение',
            'summ_month' => 'Платёж в месяц',
            'vnes' => 'Оплачено',
            'full' => 'Оплачено сразу',
            'last_pay_month' => 'Последний оплаченный месяц',
        ];
    }
}