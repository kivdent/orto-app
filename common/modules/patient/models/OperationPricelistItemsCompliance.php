<?php

namespace common\modules\patient\models;

use common\modules\pricelists\models\PricelistItems;

/**
 *
 * @property-read PricelistItems $pricelistItem
 */
class OperationPricelistItemsCompliance extends \common\models\OperationPricelistItemsCompliance
{
    public function getPricelistItem()
    {
        return $this->hasOne(PricelistItems::class, ['id' => 'pricelist_item_id']);
    }
}