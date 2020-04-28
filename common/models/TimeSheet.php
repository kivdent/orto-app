<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tabel_reg".
 *
 * @property int $id
 * @property int $sotr
 * @property string $in
 * @property string $out
 * @property string $date
 */
class TimeSheet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tabel_reg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sotr', 'in', 'out', 'date'], 'required'],
            [['sotr'], 'integer'],
            [['in', 'out', 'date'], 'safe'],
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
            'in' => 'In',
            'out' => 'Out',
            'date' => 'Date',
        ];
    }
}
