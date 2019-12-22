<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "operation".
 *
 * @property int $id
 * @property string $title
 * @property int $price_from
 * @property int $price_to
 */
class Operation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price_from', 'price_to'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price_from' => 'Price From',
            'price_to' => 'Price To',
        ];
    }
}
