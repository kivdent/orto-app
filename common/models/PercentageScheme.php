<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "proc_sh".
 *
 * @property int $id
 * @property string $naim
 * @property int $type
 * @property double $proc
 */
class PercentageScheme extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proc_sh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['proc'], 'number'],
            [['naim'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'naim' => 'Naim',
            'type' => 'Type',
            'proc' => 'Proc',
        ];
    }
}
