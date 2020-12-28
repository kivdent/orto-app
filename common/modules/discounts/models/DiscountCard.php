<?php


namespace common\modules\discounts\models;

/**
 * Class DiscountCard
 * @package common\modules\discounts\models
 * @property string $typeName
 */
class DiscountCard extends \common\models\DiscountCard
{
    const TYPE_3 = '1';
    const TYPE_5 = '2';
    const TYPE_10 = '3';


    public function getTypeName()
    {
        return $this->typeLabels()[$this->type];
    }

    public function typeLabels()
    {
        return [
            self::TYPE_3 => '3 %',
            self::TYPE_5 => '5 %',
            self::TYPE_10 => '10 %',
        ];
    }
}