<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "clinics".
 *
 * @property int $id
 * @property string $name
 * @property int $address
 * @property string $phone
 * @property string $record_phone
 * @property string $additional_phones
 * @property string $description
 * @property string $logo
 * @property int $requisites
 */
class Clinics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clinics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['address', 'requisites'], 'integer'],
            [['additional_phones', 'description'], 'string'],
            [['name', 'phone', 'record_phone', 'logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'record_phone' => 'Record Phone',
            'additional_phones' => 'Additional Phones',
            'description' => 'Description',
            'logo' => 'Logo',
            'requisites' => 'Requisites',
        ];
    }
}
