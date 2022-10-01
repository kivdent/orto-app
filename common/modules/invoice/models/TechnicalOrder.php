<?php


namespace common\modules\invoice\models;
use common\modules\employee\models\Employee;
use common\modules\invoice\models\Invoice;


/**
 * @property Invoice $invoice
 * @property Invoice $technicalOrderInvoice
 *
 */

class TechnicalOrder extends \common\models\TechnicalOrder
{


    public static function getUnclosed($employeeId,$patientId,$startDate,$endDate)
    {

        $technicalOrders= self::find()
            ->leftJoin(Invoice::tableName(), 'technical_order.invoice_id=invoice.id')
            ->where([
                'technical_order.completed' => 0,
                'invoice.doctor_id'=>$employeeId,
                'invoice.patient_id'=>$patientId,
            ])
            ->andWhere('invoice.created_at>=\'' . $startDate.'\'')
            ->andWhere('invoice.created_at<= \'' . $endDate.'\'')
            ->all();
        return $technicalOrders;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'Счёт',
            'employee_id' => 'Зубной техник',
            'delivery_date' => 'Дата сдачи работы',
            'technical_order_invoice_id' => 'Заказ-наряд',
            'completed' => 'Сдан',
        ];
    }

    public function getPatientFullName()
    {
        return $this->invoice->patientFullName;
    }

    public function isPaid()
    {
        return $this->invoice->amount_residual == 0;
    }

    public function getTechnic()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }
    public function getTechnicFullName()
    {
        return $this->technic->fullName;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTechnicalOrderInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'technical_order_invoice_id']);
    }
}