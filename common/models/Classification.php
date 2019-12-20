<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "klass".
 *
 * @property int $id
 * @property string $Nazv
 * @property int $Razd
 */
class Classification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'klass';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Razd'], 'integer'],
            [['Nazv'], 'string', 'max' => 50],
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
            'Razd' => 'Razd',
        ];
    }
}
