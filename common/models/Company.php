<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "firms".
 *
 * @property int $id
 * @property string $nazv
 * @property string $index
 * @property string $strana
 * @property string $region
 * @property string $gorod
 * @property string $adres
 * @property string $tel1
 * @property string $tel2
 * @property string $fax
 * @property string $eMail
 * @property string $www
 * @property string $OKUD
 * @property string $OKPO
 * @property string $INN
 * @property string $KPP
 * @property string $bank
 * @property string $R_sch
 * @property string $K_sch
 * @property string $BIK
 * @property int $sv
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'firms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sv'], 'integer'],
            [['nazv', 'bank', 'R_sch', 'K_sch'], 'string', 'max' => 60],
            [['index'], 'string', 'max' => 6],
            [['strana', 'region', 'gorod', 'OKUD', 'OKPO', 'INN', 'KPP', 'BIK'], 'string', 'max' => 20],
            [['adres'], 'string', 'max' => 50],
            [['tel1', 'tel2', 'fax', 'eMail', 'www'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nazv' => 'Nazv',
            'index' => 'Index',
            'strana' => 'Strana',
            'region' => 'Region',
            'gorod' => 'Gorod',
            'adres' => 'Adres',
            'tel1' => 'Tel1',
            'tel2' => 'Tel2',
            'fax' => 'Fax',
            'eMail' => 'E Mail',
            'www' => 'Www',
            'OKUD' => 'Okud',
            'OKPO' => 'Okpo',
            'INN' => 'Inn',
            'KPP' => 'Kpp',
            'bank' => 'Bank',
            'R_sch' => 'R Sch',
            'K_sch' => 'K Sch',
            'BIK' => 'Bik',
            'sv' => 'Sv',
        ];
    }
}
