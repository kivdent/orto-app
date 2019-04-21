<?php

namespace common\modules\patient\models;

use Yii;

/**
 * This is the model class for table "klinikpat".
 *
 * @property double $id
 * @property string $surname
 * @property string $name
 * @property string $otch
 * @property string $dr
 * @property string $sex
 * @property string $adres
 * @property string $MestRab
 * @property string $prof
 * @property string $email
 * @property string $DTel
 * @property string $RTel
 * @property string $MTel
 * @property string $FLech
 * @property int $Skidka
 * @property string $Prim
 * @property int $address_id
 */
class Klinikpat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'klinikpat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dr'], 'safe'],
            [['Skidka', 'address_id'], 'integer'],
            [['Prim'], 'required'],
            [['Prim'], 'string'],
            [['surname'], 'string', 'max' => 20],
            [['name', 'otch', 'MestRab', 'prof', 'DTel', 'RTel', 'MTel', 'FLech'], 'string', 'max' => 15],
            [['sex'], 'string', 'max' => 5],
            [['adres'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'surname' => 'Surname',
            'name' => 'Name',
            'otch' => 'Otch',
            'dr' => 'Dr',
            'sex' => 'Sex',
            'adres' => 'Adres',
            'MestRab' => 'Mest Rab',
            'prof' => 'Prof',
            'email' => 'Email',
            'DTel' => 'D Tel',
            'RTel' => 'R Tel',
            'MTel' => 'M Tel',
            'FLech' => 'F Lech',
            'Skidka' => 'Skidka',
            'Prim' => 'Prim',
            'address_id' => 'Address ID',
        ];
    }
}
