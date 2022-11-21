<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orto_sh".
 *
 * @property int $id
 * @property int $pat
 * @property int $sotr
 * @property string $date
 * @property int $per_lech
 * @property int $summ
 * @property int $summ_month
 * @property int $vnes
 * @property int $full
 * @property int $last_pay_month
 */
class SchemeOrthodontics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orto_sh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pat', 'sotr', 'per_lech', 'summ', 'summ_month', 'vnes', 'full', 'last_pay_month'], 'integer'],
            [['date'], 'safe'],
            [['per_lech', 'summ', 'summ_month'], 'required'],
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
            'sotr' => 'Sotr',
            'date' => 'Date',
            'per_lech' => 'Per Lech',
            'summ' => 'Summ',
            'summ_month' => 'Summ Month',
            'vnes' => 'Vnes',
            'full' => 'Full',
            'last_pay_month' => 'Last Pay Month',
        ];
    }
}
