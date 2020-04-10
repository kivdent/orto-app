<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "disc_cards".
 *
 * @property int $id
 * @property int $pat
 * @property int $type
 * @property int $num
 * @property string $date
 */
class DiscountCard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'disc_cards';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pat', 'type', 'num', 'date'], 'required'],
            [['pat', 'type', 'num'], 'integer'],
            [['date'], 'safe'],
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
            'type' => 'Type',
            'num' => 'Num',
            'date' => 'Date',
        ];
    }
}
