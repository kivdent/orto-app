<?php


namespace common\modules\cash\models;


use common\modules\catalogs\models\PaymentType;
use common\modules\clinic\models\FinancialDivisions;
use common\modules\invoice\models\Invoice;
use yii\db\Expression;

class Cashbox extends \common\models\Cashbox
{
    public static function getTodayInvoices()
    {
        $date = new Expression("((DATE(created_at)='" . date('Y-m-d') . "')AND amount_payable>paid)");
        $invoices = Invoice::find()->select('patient_id')->where($date)->groupBy('patient_id')->all();
        return $invoices;
    }

    public static function getCurrentCashBox()
    {

        return self::find()->where("`date`='" . date('Y-m-d') . "'")->one();
    }

    public static function hasUnclosed()
    {
        return self::find()->where(['timeO' => '00:00:00'])->count();
    }

    public function getBalanceFinancialDivisions()
    {
        $financial_divisions_balance = [];
        foreach (FinancialDivisions::getDivisions() as $division) {
            $financial_divisions_balance['table'][$division->id]['title'] = $division->name;
            $financial_divisions_balance['table'][$division->id]['sum'] = $division->getCash($this);
            $financial_divisions_balance['labels'] = [
                'title' => 'Подразделение',
                'sum' => 'Максимальная сумма'
            ];
        }
        return $financial_divisions_balance;
    }

    public function isClosed()
    {
        return $this->timeO != '00:00:00';
    }

    public function getFinancialDivisions()
    {
        return FinancialDivisions::getDivisionList();
    }

    public function getPaymentTypes()
    {
        return Payment::getFullTypeList();
    }

    public function getAccountCash()
    {
        return $this->hasMany(AccountCash::className(), ['smena' => 'id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sotr' => 'Сотрудник',
            'date' => 'Дата',
            'timeN' => 'Начало',
            'timeO' => 'Окончание',
            'summ' => 'Сумма',
        ];
    }

    public function getPreviousBalance()
    {
        return self::find()
            ->where(['<>', 'id', $this->id])
            ->orderBy('date DESC')
            ->one()
            ->summ;
    }
}