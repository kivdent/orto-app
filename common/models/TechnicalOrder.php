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
 * @property int $technical_order_invoice_id
 * @property int $completed
 * @property string $completed_date
 * @property string $comment
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
            [['invoice_id', 'employee_id', 'technical_order_invoice_id', 'completed'], 'integer'],
            [['delivery_date', 'completed_date'], 'safe'],
            [['comment'], 'string', 'max' => 255],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'id']],
            [['technical_order_invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['technical_order_invoice_id' => 'id']],
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
            'technical_order_invoice_id' => 'Technical Order Invoice ID',
            'completed' => 'Completed',
            'completed_date' => 'Completed Date',
            'comment' => 'Comment',
        ];
    }
}
