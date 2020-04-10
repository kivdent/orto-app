<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kassa".
 *
 * @property int $id
 * @property int $sotr
 * @property string $date
 * @property string $timeN
 * @property string $timeO
 * @property double $summ
 */
class Cashbox extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kassa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sotr'], 'integer'],
            [['date', 'timeN', 'timeO'], 'safe'],
            [['summ'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sotr' => 'Sotr',
            'date' => 'Date',
            'timeN' => 'Time N',
            'timeO' => 'Time O',
            'summ' => 'Summ',
        ];
    }
}
