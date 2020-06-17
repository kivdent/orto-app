<?php


namespace common\modules\salary\models;


use common\modules\employee\models\Employee;

/**
 * Class SalaryCard
 * @package common\modules\salary\models
 * @property Employee $employee
 * @property string $employeeName

 */

class SalaryCard extends \common\models\SalaryCard
{



    public static function getTypeSelection($type)
    {
        $cards=self::find()
            ->where(['type'=>$type])
            ->joinWith('employee')
            ->andWhere(['sotr.status'=>Employee::STATUS_WORKED])
            ->all();
        return $cards;
    }

    public function getEmployee(){
        return $this->hasOne(Employee::className(),['id'=>'sotr'])->orderBy('surname');
    }

    public function getEmployeeName(){
        return $this->employee->fullName;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sotr' => 'Сотрудник',
            'type' => 'Тип',
            'stavka' => 'Ставка',
            'ps' => 'Процентная ставка',
            'ph' => 'Оплата в час',
            'pn' => 'Подоходный налог',
        ];
    }
}