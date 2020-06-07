<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "technical_order".
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $employee_id
 * @property string $delivery_date
 *
 * @property Invoice $invoice
 */
class TechnicalOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'technical_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_id', 'employee_id'], 'integer'],
            [['delivery_date'], 'safe'],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'Invoice ID',
            'employee_id' => 'Employee ID',
            'delivery_date' => 'Delivery Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }
}
