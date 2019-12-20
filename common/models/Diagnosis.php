<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ds".
 *
 * @property int $id
 * @property string $Nazv
 * @property int $upID
 * @property int $KlassID
 * @property int $Cat
 */
class Diagnosis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ds';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['upID', 'KlassID', 'Cat'], 'integer'],
            [['Nazv'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Nazv' => 'Название',
            'upID' => 'Up I D',
            'KlassID' => 'Klass I D',
            'Cat' => 'Cat',
        ];
    }
}
