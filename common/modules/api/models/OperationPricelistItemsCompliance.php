<?php

namespace common\modules\api\models;

class OperationPricelistItemsCompliance extends \common\modules\patient\models\OperationPricelistItemsCompliance
{
    public function fields()
    {
        return [
            //'id',
            // 'operation_id',
            // 'pricelist_item_id',
            'quantity',
            'id' => function () {
                return $this->pricelistItem->priceForItem->id;
            },
            'title' => function () {
                return $this->pricelistItem->title;
            },
            'price' => function () {
                return $this->pricelistItem->priceForItem->price;
            },
        ];
    }
}