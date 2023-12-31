<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoice_items".
 *
 * @property int $id
 * @property int $prices_id
 * @property int $quantity
 * @property int $invoice_id
 *

 */
class InvoiceItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prices_id', 'quantity', 'invoice_id'], 'integer'],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'id']],
            [['prices_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prices::className(), 'targetAttribute' => ['prices_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prices_id' => 'Prices ID',
            'quantity' => 'Quantity',
            'invoice_id' => 'Invoice ID',
        ];
    }

}
