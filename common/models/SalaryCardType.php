<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zc_type".
 *
 * @property int $id
 * @property string $naim
 */
class SalaryCardType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zc_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['naim'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'naim' => 'Naim',
        ];
    }
}
