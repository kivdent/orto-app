<?php

namespace common\modules\pricelists\models;
/**
 * @property PricelistItems $pricelistItem
 * @property PricelistItems $complinceItem
 */
class PricelistItemCompliances extends \common\models\PricelistItemCompliances
{
    public function getPricelistItem()
    {
        return $this->hasOne(PricelistItems::class, ['id' => 'pricelist_item_id']);
    }
    public function getComplinceItem()
    {
        return $this->hasOne(PricelistItems::class, ['id' => 'compliance_item_id']);
    }
}