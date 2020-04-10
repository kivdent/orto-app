<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pricelist_items".
 *
 * @property int $id
 * @property string $title
 * @property int $pricelist_id
 * @property int $category
 * @property int $superior_category_id
 * @property int $active
 *
 * @property Pricelist $pricelist
 */
class PricelistItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pricelist_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pricelist_id', 'category', 'superior_category_id', 'active'], 'integer'],
            [['title'], 'string', 'max' => 255,],
            [['title'], 'required',],
            [['pricelist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pricelist::className(), 'targetAttribute' => ['pricelist_id' => 'id']],
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
            'pricelist_id' => 'Pricelist ID',
            'category' => 'Category',
            'superior_category_id' => 'Superior Category ID',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPricelist()
    {
        return $this->hasOne(Pricelist::className(), ['id' => 'pricelist_id']);
    }
}
