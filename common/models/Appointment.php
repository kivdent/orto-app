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
            [['Perv', 'PatID', 'dayPR', 'SoderzhNaz', 'RezObzv', 'Yavka'], 'integer'],
            [['NachNaz', 'OkonchNaz', 'NachPr', 'OkonchPr'], 'safe'],
            [['NachPr', 'OkonchPr'], 'required'],
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
        ];
    }
}