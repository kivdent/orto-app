<?php


namespace common\modules\sale\models;


class GiftCard extends \common\models\GiftCard
{
    const TYPE_CASH = '1';

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'number' => 'Номер',
            'balance' => 'Баланс',
            'cliniс_gift' => 'Подарок',
        ];
    }
}