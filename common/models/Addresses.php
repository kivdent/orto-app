<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "addresses".
 *
 * @property int $id
 * @property int $postcode
 * @property string $city
 * @property string $street
 * @property string $house
 * @property string $apartment
 */
class Addresses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['postcode', 'street', 'house'], 'required'],
            [['postcode'], 'integer'],
            [['city'], 'string', 'max' => 25],
            [['street'], 'string', 'max' => 100],
            [['house'], 'string', 'max' => 20],
            [['apartment'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'postcode' => 'Postcode',
            'city' => 'City',
            'street' => 'Street',
            'house' => 'House',
            'apartment' => 'Apartment',
        ];
    }
}
