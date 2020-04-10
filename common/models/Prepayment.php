<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "avans".
 *
 * @property int $id
 * @property int $pat
 * @property int $avans
 */
class Prepayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'avans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pat', 'avans'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pat' => 'Pat',
            'avans' => 'Avans',
        ];
    }
}
