<?php

namespace common\modules\schedule\models;

use Yii;

/**
 * This is the model class for table "raspis_pack".
 *
 * @property int $id
 * @property string $DateD
 * @property int $vrachID
 * @property int $prodpr
 * @property int $doctor_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $start_date
 * @property int $status
 * @property int $appointment_duration
 */
class BaseSchedules extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'raspis_pack';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DateD', 'created_at', 'updated_at', 'start_date'], 'safe'],
            [['vrachID', 'prodpr', 'doctor_id', 'status', 'appointment_duration'], 'integer'],
            [['doctor_id', 'status', 'appointment_duration'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'DateD' => 'Date D',
            'vrachID' => 'Vrach I D',
            'prodpr' => 'Prodpr',
            'doctor_id' => 'Doctor ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'start_date' => 'Start Date',
            'status' => 'Status',
            'appointment_duration' => 'Appointment Duration',
        ];
    }
}
