<?php


namespace common\modules\cash\models;


use common\modules\catalogs\models\PaymentType;
use common\modules\clinic\models\FinancialDivisions;
use common\modules\invoice\models\Invoice;
use common\modules\sale\models\GiftCard;
use Yii;

use Throwable;

/* @property Invoice $invoice */
/* @property FinancialDivisions $financialDivision */
/* @property string $typeName */

class Payment extends \common\models\Payment
{

    public static function getRealPaymentsForPatient($patientId)
    {
        return self::find()->
        leftJoin(Invoice::tableName(), 'invoice.id=' . 'oplata.dnev')
            ->where(['invoice.patient_id' => $patientId])
            ->andWhere('oplata.VidOpl in (' . PaymentType::TYPE_BANK_CARD . ', ' . PaymentType::TYPE_CASH . ')')
            ->orderBy('oplata.date')
            ->all();
    }

    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'dnev']);
    }

    public function getTypeList()
    {
        $paymentType = [
            PaymentType::TYPE_CASH => 'Наличные',
            PaymentType::TYPE_BANK_CARD => 'Банковская карта',
            PaymentType::TYPE_GIFT_CARD => 'Подарочная карта'
        ];
        if ($this->invoice->patient->agreement != null) {
            $paymentType[PaymentType::TYPE_AGREEMENT] = 'По договору';
        }
        if ($this->invoice->patient->prepayment != null) {
            $paymentType[PaymentType::TYPE_PREPAYMENT] = 'Из аванса';
        }
        if ($this->invoice->patient->fullDiscountCard != null) {
            $paymentType[PaymentType::TYPE_FULL_DISCOUNT] = 'По 10%  карте';
        }

        return $paymentType;
    }

    public static function getFullTypeList()
    {
        $paymentType = [
            PaymentType::TYPE_CASH => 'Наличные',
            PaymentType::TYPE_BANK_CARD => 'Банковская карта',
            PaymentType::TYPE_GIFT_CARD => 'Подарочная карта',
            PaymentType::TYPE_AGREEMENT => 'По договору',
            PaymentType::TYPE_PREPAYMENT => 'Из аванса',
            PaymentType::TYPE_FULL_DISCOUNT => 'По 10%  карте',
        ];


        return $paymentType;
    }

    public function getTypeName()
    {
        return $this->fullTypeList[$this->VidOpl];
    }

    public function rules()
    {
        $rules = parent::rules();
        if ($this->invoice) {
            $rules[] = [['vnes'], 'integer', 'min' => 1, 'max' => $this->invoice->amount_residual];
        }
        $rules[] = [['vnes'], 'required'];

        return $rules;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'time' => 'Время',
            'dnev' => 'Счёт',
            'vnes' => 'Внесённая сумма',
            'VidOpl' => 'Вид оплаты',
            'podr' => 'Подразделение',
            'type' => 'Тип',
        ];
    }

    /**
     * @throws
     * @var $cahbox Cashbox
     */
    public function makePayment()
    {

        $transaction = Payment::getDb()->beginTransaction();
        try {

            switch ($this->VidOpl) {
                case PaymentType::TYPE_CASH:
                    $cashbox = Cashbox::getCurrentCashBox();
                    $cashbox->summ += $this->vnes;
                    $cashbox->save(false);
                    break;
                case PaymentType::TYPE_PREPAYMENT:
                    if ($this->vnes > $this->invoice->patient->prepayment->avans) {
                        Yii::$app->session->setFlash('error', 'Сумма не может быть больше остатка аванса в ' . $this->invoice->patient->prepayment->avans . ' р.');
                        return false;
                    }
                    $this->invoice->patient->prepayment->avans -= $this->vnes;
                    $this->invoice->patient->prepayment->save(false);
                    break;
                case PaymentType::TYPE_GIFT_CARD:


                    break;
            }


            switch ($this->invoice->type) {
                case Invoice::TYPE_ORTHODONTICS:
                    $this->invoice->patient->schemeOrthodontics->vnes += $this->vnes;
                    $this->invoice->patient->schemeOrthodontics->last_pay_month++;
                    $this->invoice->patient->schemeOrthodontics->save(false);
                    break;
                case Invoice::TYPE_PREPAYMENT:
                    $prepayment = $this->invoice->patient->prepayment;
                    if (!$prepayment) {
                        $prepayment = new Prepayment();
                        $prepayment->pat = $this->invoice->patient_id;
                        $prepayment->avans = 0;
                    }
                    $prepayment->avans += $this->vnes;
                    $prepayment->save(false);
                    $this->invoice->amount = $this->vnes;
                    $this->invoice->amount_payable = $this->vnes;
                    $this->invoice->paid = 0;

                    break;

            }
            $this->invoice->paid += $this->vnes;
            $this->invoice->save(false);

            $this->save(false);
            $transaction->commit();
            return true;
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
        return false;
    }

    public function getFinancialDivision()
    {
        return $this->hasOne(FinancialDivisions::class, ['id' => 'podr']);
    }

}