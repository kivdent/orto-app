<?php


namespace common\modules\invoice\models;


use common\modules\employee\models\Employee;
use common\modules\patient\models\Patient;
use common\modules\userInterface\models\UserInterface;

/**
 * @property Patient $patient
 * @property Employee $employee
 *
 * @property string $patientFullName
 * @property string $employeeFullName
 */
class SchemeOrthodontics extends \common\models\SchemeOrthodontics
{
    const SCHEME_PAID = 'paid';
    const SCHEME_NOT_PAID = 'not_paid';

    public function attributeLabels()
    {
        return [
            'id' => 'Номер',
            'pat' => 'Пацинет',
            'sotr' => 'Врач',
            'date' => 'Дата создания',
            'per_lech' => 'Срок лечения',
            'summ' => 'Обшая сумма за лечение',
            'summ_month' => 'Платёж в месяц',
            'vnes' => 'Оплачено',
            'full' => 'Оплачено сразу',
            'last_pay_month' => 'Последний оплаченный месяц',
            'patientFullName' => 'Пациент',
            'employeeFullName' => 'Сотрудник'
        ];
    }

    public function isCompleted()
    {
        return $this->vnes === $this->summ;
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'pat']);
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'sotr']);
    }

    public function getPatientFullName()
    {
        return $this->patient->surname . ' ' . $this->patient->name . ' ' . $this->patient->otch;
    }

    public function getEmployeeFullName()
    {
        return $this->employee->fullName;
    }

    public function getAmount()
    {
        $balance = (int)$this->summ - (int)$this->vnes;
        $amount = $balance < $this->summ_month ? $balance : $this->summ_month;
        return $amount;
    }

}