<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "manip".
 *
 * @property int $id
 * @property string $manip
 * @property int $preysk
 * @property string $zapis
 * @property int $price
 * @property int $cat
 * @property int $UpId
 * @property int $range
 * @property double $koef
 */
class Manipulations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preysk', 'price', 'cat', 'UpId', 'range'], 'integer'],
            [['koef'], 'number'],
            [['manip'], 'string', 'max' => 150],
            [['zapis'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'manip' => 'Manip',
            'preysk' => 'Preysk',
            'zapis' => 'Zapis',
            'price' => 'Price',
            'cat' => 'Cat',
            'UpId' => 'Up ID',
            'range' => 'Range',
            'koef' => 'Koef',
        ];
    }
}
