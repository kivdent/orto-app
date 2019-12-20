<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "diagnosis".
 *
 * @property int $id
 * @property string $Nazv
 * @property int $upID
 * @property int $KlassID
 * @property int $Cat
 * @property int $code
 */
class DiagnosisTest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'diagnosis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['upID', 'KlassID', 'Cat', 'code'], 'integer'],
            [['Nazv'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Nazv' => 'Nazv',
            'upID' => 'Up I D',
            'KlassID' => 'Klass I D',
            'Cat' => 'Cat',
            'code' => 'Code',
        ];
    }
}
