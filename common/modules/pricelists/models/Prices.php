<?php


namespace common\modules\pricelists\models;


class Prices extends \common\models\Prices
{


    public function isChanged()
    {
        $oldPrices = self::findOne($this->id);
        return !(($this->price == $oldPrices->price) and ($this->coefficient == $oldPrices->coefficient));
    }
}