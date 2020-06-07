<?php


namespace common\modules\invoice\models;


class TechnicalOrder extends \common\models\TechnicalOrder
{



    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'Счёт',
            'employee_id' => 'Зубной техник',
            'delivery_date' => 'Дата сдачи работы',
        ];
    }

}