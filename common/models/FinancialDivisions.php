<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "podr".
 *
 * @property int $id
 * @property string $nazv
 */
class FinancialDivisions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'podr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nazv'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nazv' => 'Nazv',
        ];
    }
}
