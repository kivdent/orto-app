<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "certif".
 *
 * @property int $id
 * @property int $type
 * @property int $number
 * @property int $balance
 * @property int $cliniс_gift
 */
class GiftCard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'certif';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'number'], 'required'],
            [['type', 'number', 'balance', 'cliniс_gift'], 'integer'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'number' => 'Number',
            'balance' => 'Balance',
            'cliniс_gift' => 'Cliniс Gift',
        ];
    }
}
