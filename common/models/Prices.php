<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "prices".
 *
 * @property int $id
 * @property int $pricelist_items_id
 * @property int $price
 * @property double $coefficient
 * @property string $created_at
 * @property string $updated_at
 * @property int $active
 *
 * @property PricelistItems $pricelistItems
 * @property string $title
 */
class Prices extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pricelist_items_id', 'price', 'active'], 'integer'],
            [['coefficient'], 'number'],
            [['coefficient', 'price'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['pricelist_items_id'], 'exist', 'skipOnError' => true, 'targetClass' => PricelistItems::className(), 'targetAttribute' => ['pricelist_items_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pricelist_items_id' => 'Pricelist Items ID',
            'price' => 'Цена',
            'coefficient' => 'Коэффициент',
            'created_at' => 'Создан',
            'updated_at' => 'Изменён',
            'active' => 'Активность',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPricelistItems()
    {
        return $this->hasOne(PricelistItems::className(), ['id' => 'pricelist_items_id']);
    }

    public function getTitle()
    {
        return $this->pricelistItems->title;
    }
}
