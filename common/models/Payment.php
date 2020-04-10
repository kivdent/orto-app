<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "oplata".
 *
 * @property int $id
 * @property string $date
 * @property string $time
 * @property int $dnev
 * @property int $vnes
 * @property int $VidOpl
 * @property int $podr
 * @property int $type
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oplata';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'time'], 'safe'],
            [['dnev', 'vnes', 'VidOpl', 'podr', 'type'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'time' => 'Time',
            'dnev' => 'Dnev',
            'vnes' => 'Vnes',
            'VidOpl' => 'Vid Opl',
            'podr' => 'Podr',
            'type' => 'Type',
        ];
    }
}
