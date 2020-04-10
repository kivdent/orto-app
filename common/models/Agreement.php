<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dogovor".
 *
 * @property int $id
 * @property int $firm
 * @property int $pat
 */
class Agreement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dogovor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firm', 'pat'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firm' => 'Firm',
            'pat' => 'Pat',
        ];
    }
}
