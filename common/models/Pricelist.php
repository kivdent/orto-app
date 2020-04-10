<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pricelist".
 *
 * @property int $id
 * @property string $title
 * @property int $active
 * @property string $type
 *
 * @property PricelistItems[] $pricelistItems
 */
class Pricelist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pricelist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active'], 'integer'],
            [['title', 'type'], 'string', 'max' => 255],
            [['title', 'type'], 'required'],
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
            'active' => 'Active',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPricelistItems()
    {
        return $this->hasMany(PricelistItems::className(), ['pricelist_id' => 'id']);
    }
}
