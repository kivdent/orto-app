<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sn_kass".
 *
 * @property int $id
 * @property int $smena
 * @property int $znak
 * @property double $summ
 * @property int $oper
 * @property int $otv
 * @property int $podr
 */
class AccountCash extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sn_kass';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['smena', 'znak', 'oper', 'otv', 'podr'], 'integer'],
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
            'smena' => 'Smena',
            'znak' => 'Znak',
            'summ' => 'Summ',
            'oper' => 'Oper',
            'otv' => 'Otv',
            'podr' => 'Podr',
        ];
    }
}
