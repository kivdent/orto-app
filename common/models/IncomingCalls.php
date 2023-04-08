<?php

namespace common\models;

use common\modules\employee\models\Employee;
use Yii;

/**
 * This is the model class for table "incoming_calls".
 *
 * @property int $id
 * @property int $doctor_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $employee_id
 * @property int $primary_patient
 * @property string $call_target
 * @property string $call_result
 * @property int $by_recommendation
 * @property int $rejection_reasons_id
 *
 * @property Employee $doctor
 * @property Employee $employee
 * @property RejectionReasons $rejectionReasons
 */
class IncomingCalls extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'incoming_calls';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'primary_patient', 'call_result', 'rejection_reasons_id'], 'required'],
            [[ 'employee_id', 'primary_patient', 'by_recommendation', 'rejection_reasons_id'], 'integer'],
            [['created_at', 'updated_at','doctor_id',], 'safe'],
            [['doctor_id','call_target'], 'string'],
            [['call_result'], 'string', 'max' => 255],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['doctor_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['rejection_reasons_id'], 'exist', 'skipOnError' => true, 'targetClass' => RejectionReasons::className(), 'targetAttribute' => ['rejection_reasons_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doctor_id' => 'Doctor ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'employee_id' => 'Employee ID',
            'primary_patient' => 'Primary Patient',
            'call_target' => 'Call Target',
            'call_result' => 'Call Result',
            'by_recommendation' => 'By Recommendation',
            'rejection_reasons_id' => 'Rejection Reasons ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Sotr::className(), ['id' => 'doctor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Sotr::className(), ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRejectionReasons()
    {
        return $this->hasOne(RejectionReasons::className(), ['id' => 'rejection_reasons_id']);
    }
}
