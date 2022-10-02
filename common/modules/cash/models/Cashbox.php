<?php


namespace common\modules\cash\models;


use common\modules\catalogs\models\PaymentType;
use common\modules\clinic\models\FinancialDivisions;
use common\modules\invoice\models\Invoice;
use common\modules\userInterface\models\UserInterface;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class Cashbox extends \common\models\Cashbox
{
    public static function getTodayInvoices()
    {
        $date = new Expression("((DATE(created_at)='" . date('Y-m-d') . "')AND amount_payable>paid)");
        $invoices = Invoice::find()->select('patient_id')->where($date)->andWhere("type<>'".Invoice::TYPE_TECHNICAL_ORDER."'")->groupBy('patient_id')->all();
        return $invoices;
    }

    public static function getCurrentCashBox()
    {

        return self::find()->where('`date`=\'' . date('Y-m-d') . "'")->one();
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

    public function getAccountCashSummForDivision(FinancialDivisions $division)
    {
//        ArrayHelper::getColumn()
//        UserInterface::getVar(ArrayHelper::toArray($this->getAccountCashForDivision($division)));
        return array_sum(ArrayHelper::getColumn($this->getAccountCashForDivision($division), 'summ'));
    }

    public function getAccountCashForDivision(FinancialDivisions $division)
    {
        return AccountCash::find()->where(['smena' => $this->id, 'podr' => $division->id,])->all();
    }
}