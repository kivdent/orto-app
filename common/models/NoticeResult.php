<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rezobzv".
 *
 * @property int $id
 * @property string $RezObzv
 */
class NoticeResult extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rezobzv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['RezObzv'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'RezObzv' => 'Rez Obzv',
        ];
    }
}
