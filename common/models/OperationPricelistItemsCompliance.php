<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "operation_pricelist_items_compliance".
 *
 * @property int $id
 * @property int $operation_id
 * @property int $pricelist_item_id
 * @property int $quantity
 */
class OperationPricelistItemsCompliance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operation_pricelist_items_compliance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['operation_id', 'pricelist_item_id', 'quantity'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'operation_id' => 'Operation ID',
            'pricelist_item_id' => 'Pricelist Item ID',
            'quantity' => 'Quantity',
        ];
    }
}
