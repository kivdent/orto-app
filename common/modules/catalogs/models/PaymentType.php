<?php


namespace common\modules\catalogs\models;


use yii\helpers\ArrayHelper;

class PaymentType extends \common\models\PaymentType
{
    const TYPE_CASH = 1;//'1', 'Наличные'
    const TYPE_AGREEMENT = 2;//'2', 'По договору'
    const TYPE_PREPAYMENT = 3;//'3', 'Из аванса'
    const TYPE_FULL_DISCOUNT = 4;//'4', 'По 10%  карте'
    const TYPE_BANK_CARD=5;//'5', 'Банковская карта'
    const TYPE_GIFT_CARD=6;//'6', 'Подарочная карта'


    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'vid');
    }
}