<?php

namespace common\modules\clinic\models;

use Yii;

/**
 * This is the model class for table "days_in_clinic_sheudles".
 *
 * @property int $id
 * @property int $sheudle_id
 * @property int $day_number
 * @property int $holiday
 * @property string $start
 * @property string $end
 */
class DaysInClinicSheudles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'days_in_clinic_sheudles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sheudle_id', 'day_number', 'holiday'], 'integer'],
            [['start', 'end'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sheudle_id' => 'Sheudle ID',
            'day_number' => 'Day Number',
            'holiday' => 'Holiday',
            'start' => 'Start',
            'end' => 'End',
        ];
    }
}
