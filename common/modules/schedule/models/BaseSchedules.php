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
    const STATUS_ACTIVE='1';
    const STATUS_INACTIVE='0';
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
            [['DateD', 'start_date'], 'safe'],
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
            'DateD' => 'Начало',
            'vrachID' => 'Врач',
            'prodpr' => 'Прод. приёма',
            'doctor_id' => 'Врач',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'start_date' => 'Начало',
            'status' => 'Статус',
            'appointment_duration' => 'Прод. приёма',
        ];
    }
}
