<?php

namespace common\models;
use common\modules\invoice\models\InvoiceItems;
use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $patient_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $amount
 * @property int $amount_payable
 * @property int $paid
 * @property int $discount_id
 * @property int $appointment_id
 * @property string $type
 *
 * @property InvoiceItems[] $invoiceItems
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doctor_id', 'patient_id', 'amount', 'amount_payable', 'paid', 'discount_id', 'appointment_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doctor_id' => 'Doctor ID',
            'patient_id' => 'Patient ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'amount' => 'Amount',
            'amount_payable' => 'Amount Payable',
            'paid' => 'Paid',
            'discount_id' => 'Discount ID',
            'appointment_id' => 'Appointment ID',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceItems()
    {
        return $this->hasMany(InvoiceItems::className(), ['invoice_id' => 'id']);
    }
}
