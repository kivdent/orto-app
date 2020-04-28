<?php


namespace common\modules\cash\models;

use common\modules\catalogs\models\AccountCashType;
use common\modules\employee\models\Employee;

/**
 * This is the model class for table "sn_kass".
 *
 * @property int $id
 * @property int $smena
 * @property int $znak
 * @property double $summ
 * @property int $oper
 * @property int $otv
 * @property int $podr
 */
class AccountCash extends \common\models\AccountCash
{
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'otv']);
    }

    public function getType()
    {
        return $this->hasOne(AccountCashType::className(), ['id' => 'oper']);
    }

    public function getTypeName()
    {
        return $this->type->naim;
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'smena' => 'Смена',
            'znak' => 'Znak',
            'summ' => 'Сумма',
            'oper' => 'Операция',
            'otv' => 'Ответственный',
            'podr' => 'Подразделение',
        ];
    }
}