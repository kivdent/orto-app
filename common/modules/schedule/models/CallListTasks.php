<?php

namespace common\modules\schedule\models;

use common\modules\employee\models\Employee;
use common\modules\patient\models\Patient;
use common\modules\userInterface\models\UserInterface;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property  $patient
 * @property Employee $employee
 * @property Employee $doctor
 */
class CallListTasks extends \common\models\CallListTasks
{
    const TASK_DIDNT_CALL = 'didnt_call';
    const TASK_DOESNT_ANSWER = 'doesnt_answer';
    const TASK_CALL_BACK_OWN = 'call_back_own';
    const TASK_SEE_IN_COMMENT = 'see_in_comment';
    const TASK_APPOINTED = 'appointed';
    const TASK_NOTIFIED = 'notified';

    const TASK_STATUS_ACTIVE='status_active';
    const TASK_STATUS_INACTIVE='status_inactive';

    public static function GetResultList()
    {
        return [
            self::TASK_DIDNT_CALL => 'Не звонили',
            self::TASK_DOESNT_ANSWER => 'Не отвечает',
            self::TASK_CALL_BACK_OWN => 'Перезонит самостоятельно',
            self::TASK_SEE_IN_COMMENT => 'Указан в комментарии',
            self::TASK_APPOINTED => 'Назначен',
            self::TASK_NOTIFIED => 'Оповещён',
        ];
    }
    public static function GetStatusList()
    {
        return [
            self::TASK_STATUS_ACTIVE=>'Активен',
            self::TASK_STATUS_INACTIVE=>'Не активен',
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'patient_id' => 'Пациент',
            'doctor_id' => 'Врач',
            'appointment_content' => 'Содержание назначения',
            'result' => 'Результат обзвона',
            'created_at' => 'Создан',
            'updated_at' => 'Изменён',
            'employee_id' => 'Автор',
            'note' => 'Заметка',
            'call_list_id' => 'Лист обзвона',
            'status' => 'Статус',
        ];
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'patient_id']);
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Employee::class, ['id' => 'doctor_id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'employee_id',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'employee_id',
                ],
                'value' => function ($event) {
                    return UserInterface::getEmployeeId();
                },
            ],
        ];
    }
}