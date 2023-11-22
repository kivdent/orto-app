<?php

namespace common\modules\documents\models;

use common\modules\employee\models\Employee;
use common\modules\patient\models\Patient;
use common\modules\userInterface\models\UserInterface;

class TemplateVariables extends \yii\base\Model
{

    const PATIENT_NAME = 'PatientName';
    const PATIENT_SURNAME = 'PatientSurname';
    const PATIENT_PATRONYMICS = 'PatientPatronymics';
    const PATIENT_FULL_NAME = 'PatientFullName';
    const PATIENT_BIRTHDAY = 'PatientBirthday';
    const PATIENT_ADDRESS = 'PatientAddress';
    const PATIENT_PHONE_NUMBER = 'PatientPhoneNumber';
    const EMPLOYEE_FULL_NAME = 'EmployeeFullName';
    const CURRENT_DATE = 'CurrentDate';

    static function getStandardVariableValue(string $variableName, array $args)
    {
        $value = '';
        $funcArgs = self::filterVariableArgs($variableName, $args);

        if ($funcArgs != null) {
            $value = call_user_func_array('self::get' . $variableName, $funcArgs);
        } else {
            throw new \Exception('Нет подходящих элементов (' . implode(', ', self::variableArgs()[$variableName]) . ') для перменной шаблона: ' . $variableName);
        }
        return $value;
    }

    static function variableArgs()
    {
        return [
            self::PATIENT_NAME => ['patient_id' => 'patient_id'],
            self::PATIENT_SURNAME => ['patient_id' => 'patient_id'],
            self::PATIENT_PATRONYMICS => ['patient_id' => 'patient_id'],
            self::PATIENT_FULL_NAME => ['patient_id' => 'patient_id'],
            self::PATIENT_ADDRESS => ['patient_id' => 'patient_id'],
            self::EMPLOYEE_FULL_NAME => ['employee_id' => 'employee_id'],
            self::PATIENT_BIRTHDAY => ['patient_id' => 'patient_id'],
            self::PATIENT_PHONE_NUMBER => ['patient_id' => 'patient_id'],
            self::CURRENT_DATE => ['current_date' => 'current_date'],
        ];
    }

    static function filterVariableArgs(string $variableName, array $args)
    {
        $funcArgs = [];

        if (isset(self::variableArgs()[$variableName])) {

            $funcArgs = array_intersect_key($args, self::variableArgs()[$variableName]);
            if (empty($funcArgs)) {
                $funcArgs = null;
            }
        } else {
            throw new \Exception('Нет подходящих элементов стандартной перменной шаблона: ' . $variableName);
            $funcArgs = null;
        }
        return $funcArgs;
    }

    static function getPatientName($patient_id)
    {
        $value = Patient::findOne($patient_id)->name;

        return $value;
    }
    static function getPatientSurname($patient_id)
    {
        $value = Patient::findOne($patient_id)->surname;

        return $value;
    }
    static function getPatientPatronymics($patient_id)
    {
        $value = Patient::findOne($patient_id)->otch;

        return $value;
    }
    static function getPatientFullName($patient_id)
    {
        $value = Patient::findOne($patient_id)->fullName;

        return $value;
    }

    static function getPatientAddress($patient_id)
    {
        $value = Patient::findOne($patient_id)->addressString;
        return $value;
    }

    static function getEmployeeFullName($employee_id)
    {
        $value = Employee::findOne($employee_id)->fullName;
        return $value;
    }

    static function getCurrentDate($current_date)
    {
        $value = date('d.m.Y');
        return $value;
    }
    static function getPatientBirthday($patient_id)
    {
        $value = Patient::findOne($patient_id)->dr;
        return $value;
    }
    static function getPatientPhoneNumber($patient_id)
    {
        $value = Patient::findOne($patient_id)->MTel;
        return $value;
    }
}