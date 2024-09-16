<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "daypr".
 *
 * @property int $id
 * @property string $date
 * @property int $vih
 * @property int $rabmestoID
 * @property string $Nach
 * @property string $Okonch
 * @property int $TimePat
 * @property int $vrachID
 * @property string $specialization_appointments_day
 * @property string $comment
 */
class AppointmentsDay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'daypr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'Nach', 'Okonch'], 'safe'],
            [['vih', 'rabmestoID', 'TimePat', 'vrachID'], 'integer'],
            [['comment'], 'string'],
            [['specialization_appointments_day'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'vih' => 'Vih',
            'rabmestoID' => 'Rabmesto ID',
            'Nach' => 'Nach',
            'Okonch' => 'Okonch',
            'TimePat' => 'Time Pat',
            'vrachID' => 'Vrach ID',
            'specialization_appointments_day' => 'Specialization Appointments Day',
            'comment' => 'Comment',
        ];
    }
}
