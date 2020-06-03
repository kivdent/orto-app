<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zarp_card".
 *
 * @property int $id
 * @property int $sotr
 * @property int $type
 * @property double $stavka
 * @property double $ps
 * @property double $ph
 * @property double $pn
 */
class SalaryCard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zarp_card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sotr', 'type'], 'integer'],
            [['stavka', 'ps', 'ph', 'pn'], 'number'],
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
            'type' => 'Type',
            'stavka' => 'Stavka',
            'ps' => 'Ps',
            'ph' => 'Ph',
            'pn' => 'Pn',
        ];
    }
}
