<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nazn".
 *
 * @property int $Id
 * @property int $Perv
 * @property int $PatID
 * @property int $dayPR
 * @property string $NachNaz
 * @property string $OkonchNaz
 * @property int $SoderzhNaz
 * @property int $RezObzv
 * @property int $Yavka
 * @property string $NachPr
 * @property string $OkonchPr
 * @property string $status
 * @property string $appointment_content
 * @property string $created_at
 * @property string $updated_at
 * @property int $employee_id
 */
class Appointment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nazn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Perv', 'PatID', 'dayPR', 'SoderzhNaz', 'RezObzv', 'Yavka', 'employee_id'], 'integer'],
            [['NachNaz', 'OkonchNaz', 'NachPr', 'OkonchPr', 'created_at', 'updated_at'], 'safe'],
            [['NachPr', 'OkonchPr'], 'required'],
            [['status', 'appointment_content'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Perv' => 'Perv',
            'PatID' => 'Pat ID',
            'dayPR' => 'Day Pr',
            'NachNaz' => 'Nach Naz',
            'OkonchNaz' => 'Okonch Naz',
            'SoderzhNaz' => 'Soderzh Naz',
            'RezObzv' => 'Rez Obzv',
            'Yavka' => 'Yavka',
            'NachPr' => 'Nach Pr',
            'OkonchPr' => 'Okonch Pr',
            'status' => 'Status',
            'appointment_content' => 'Appointment Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'employee_id' => 'Employee ID',
        ];
    }
}
