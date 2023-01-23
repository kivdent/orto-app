<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "call_list_tasks".
 *
 * @property int $id
 * @property int $patient_id
 * @property int $doctor_id
 * @property string $appointment_content
 * @property string $result
 * @property string $created_at
 * @property string $updated_at
 * @property int $employee_id
 * @property string $note
 * @property int $call_list_id
 * @property string $status
 *
 * @property CallList $callList
 */
class CallListTasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'call_list_tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['patient_id', 'doctor_id', 'result', 'employee_id', 'call_list_id'], 'required'],
            [['patient_id', 'doctor_id', 'employee_id', 'call_list_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['appointment_content', 'result', 'note', 'status'], 'string', 'max' => 255],
            [['call_list_id'], 'exist', 'skipOnError' => true, 'targetClass' => CallList::className(), 'targetAttribute' => ['call_list_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'patient_id' => 'Patient ID',
            'doctor_id' => 'Doctor ID',
            'appointment_content' => 'Appointment Content',
            'result' => 'Result',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'employee_id' => 'Employee ID',
            'note' => 'Note',
            'call_list_id' => 'Call List ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCallList()
    {
        return $this->hasOne(CallList::className(), ['id' => 'call_list_id']);
    }
}
