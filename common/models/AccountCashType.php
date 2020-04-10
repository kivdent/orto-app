<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "oper_vid".
 *
 * @property int $id
 * @property string $naim
 * @property int $znak
 */
class AccountCashType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oper_vid';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['znak'], 'integer'],
            [['naim'], 'string', 'max' => 25],
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
            'znak' => 'Znak',
        ];
    }
}
