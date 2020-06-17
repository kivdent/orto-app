<?php


namespace common\modules\invoice\models;

use common\modules\cash\models\Payment;
use common\modules\employee\models\Employee;
use common\modules\pricelists\models\Prices;
use common\modules\reports\models\FinancialPeriods;
use Yii;
use common\modules\patient\models\Patient;
use common\modules\pricelists\models\Pricelist;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use common\modules\catalogs\models\PaymentType;

/**
 * @property Employee $employee
 * @property Payment $payments
 * @property integer $amount_residual
 * @property Patient $patient
 * @property string $date
 * @property string $patientFullName
 * @property string $lastPaymentDate
 * @property Prices $prices
 * @property float $coefficientSummary
 *
 */
class Invoice extends \common\models\Invoice
{

    const TYPE_MANIPULATIONS = Pricelist::TYPE_MANIPULATIONS;
    const TYPE_MATERIALS = Pricelist::TYPE_MATERIALS;
    const TYPE_GIFT_CARDS = Pricelist::TYPE_GIFT_CARDS;
    const TYPE_ORTHODONTICS = 'orthodontics';
    const TYPE_PREPAYMENT = 'prepayment';
    const TYPE_TECHNICAL_ORDER = 'technical order';

    const SEARCH_TYPE_ALL = 'all';
    const SEARCH_TYPE_DEBT = 'debt';
    const SEARCH_TYPE_EMPLOYEE_DEBT = 'employee_debt';
    const SEARCH_TYPE_PAID = 'paid';
    const SEARCH_TYPE_FOR_PATIENT_CARD = 'for_card';
    const SEARCH_TYPE_TECHNICAL_ORDER = 'technical order';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    public function getTypeList()
    {
        $paymentType = [
            PaymentType::TYPE_CASH => 'Наличные',
            PaymentType::TYPE_BANK_CARD => 'Банковская карта',
            PaymentType::TYPE_GIFT_CARD => 'Подарочная карта'
        ];
        if ($this->patient->agreement != null) {
            $paymentType[PaymentType::TYPE_AGREEMENT] = 'По договору';
        }
        if ($this->patient->prepayment != null) {
            $paymentType[PaymentType::TYPE_PREPAYMENT] = 'Из аванса';
        }
        if ($this->patient->fullDiscountCard != null) {
            $paymentType[PaymentType::TYPE_FULL_DISCOUNT] = 'По 10%  карте';
        }

        return $paymentType;
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'patient_id']);
    }

    public function getPatientFullName()
    {
        return $this->patient ? $this->patient->fullNAme : 'Не определено';
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'doctor_id']);
    }

    public function getEmployeeFullName()
    {
        return $this->employee ? $this->employee->fullNAme : 'Не определено';
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->created_at, 'php:d.m.Y');
    }

    public static function getPatientDebts($patient_id)
    {
        return self::find()
            ->where(['patient_id' => $patient_id])
            ->andWhere('amount_payable<>paid')
            ->all();
    }

    public function getAmount_residual()
    {
        return $this->amount_payable - $this->paid;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doctor_id' => 'Врач',
            'patient_id' => 'Пациент',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
            'amount' => 'Выписано',
            'amount_payable' => 'Сумма к оплате',
            'paid' => 'Оплачено',
            'discount_id' => 'Скидка',
            'appointment_id' => 'Назначение',
            'type' => 'Тип',
            'amount_residual' => 'Остаток',
            'date' => 'Дата',
            'patientFullName' => 'Пациент',
            'employeeFullName' => 'Врач',
        ];
    }

    public static function getDateExpression($date, $comparison = '=')
    {
        //$date = new Expression("DATE(created_at)" . $comparison . "'" . $date . "'");
        $date = new Expression("created_at" . $comparison . "'" . $date . "'");
        return $date;

    }

    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['dnev' => 'id']);
    }

    public function getLastPaymentDate()
    {
        $date = Payment::find()->select('date')->where(['dnev' => $this->id])->orderBy(['date' => SORT_DESC])->one()->date;
        return $date;
    }

    public function isLastPaymentDateInPeriod(FinancialPeriods $financialPeriod)
    {
        return strtotime($this->getLastPaymentDate()) >= strtotime($financialPeriod->nach)
            && strtotime($this->getLastPaymentDate()) <= strtotime($financialPeriod->okonch);
    }

    public function getSalarySumByPriceList()
    {
        $salarySumm = [];
        if ($this->type == self::TYPE_ORTHODONTICS) {
            $salarySumm[self::TYPE_ORTHODONTICS] = $this->paid;
            return $salarySumm;
        }

        foreach ($this->invoiceItems as $invoiceItem) {
            $pricelist_id = $invoiceItem->prices->pricelistItems->pricelist_id;
            $uet = FinancialPeriods::getUETForDate($this->created_at);
            if (isset($salarySumm[$pricelist_id])) {
                $salarySumm[$pricelist_id] += $invoiceItem->coefficientSummary * $uet;
            } else {
                $salarySumm[$pricelist_id] = $invoiceItem->coefficientSummary * $uet;
            }
        }
        return $salarySumm;

    }

    public function getCoefficientSummary()
    {
        $sum = 0;
        foreach ($this->invoiceItems as $invoiceItem) {
            $sum += $invoiceItem->coefficientSummary;
        }
        return $sum;
    }

    public function getSalarySum()
    {
        $sum = 0;
        $uet = FinancialPeriods::getUETForDate($this->created_at);
        $sum += $this->coefficientSummary * $uet;
        return $sum;
    }

    public function getTechnicalOrder()
    {
        return $this->hasOne(TechnicalOrder::className(), ['technical_order_invoice_id' => 'id']);
    }

    public function getTechnicalOrderForInvoice()
    {
        return $this->hasOne(TechnicalOrder::className(), ['invoice_id' => 'id']);
    }

    public function getTechnicalOrderInvoice()
    {
        return $this->technicalOrderForInvoice->technicalOrderInvoice;
    }
    public function getDoctorInvoiceForTechnicalOrder()
    {
        return $this->technicalOrder->invoice;
    }

}
