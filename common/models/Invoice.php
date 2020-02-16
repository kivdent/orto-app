<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dnev".
 *
 * @property int $id
 * @property int $vrach
 * @property int $pat
 * @property string $date
 * @property int $osm
 * @property string $ds
 * @property string $zh
 * @property string $an
 * @property string $obk
 * @property string $lech
 * @property int $resl
 * @property int $summ
 * @property int $summ_k_opl
 * @property int $summ_vnes
 * @property int $skidka
 * @property int $nzub
 * @property int $Nid
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dnev';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vrach', 'pat', 'osm', 'resl', 'summ', 'summ_k_opl', 'summ_vnes', 'skidka', 'nzub', 'Nid'], 'integer'],
            [['date'], 'safe'],
            [['ds', 'zh', 'an', 'obk', 'lech', 'Nid'], 'required'],
            [['ds', 'zh', 'an', 'obk', 'lech'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vrach' => 'Vrach',
            'pat' => 'Pat',
            'date' => 'Date',
            'osm' => 'Osm',
            'ds' => 'Ds',
            'zh' => 'Zh',
            'an' => 'An',
            'obk' => 'Obk',
            'lech' => 'Lech',
            'resl' => 'Resl',
            'summ' => 'Summ',
            'summ_k_opl' => 'Summ K Opl',
            'summ_vnes' => 'Summ Vnes',
            'skidka' => 'Skidka',
            'nzub' => 'Nzub',
            'Nid' => 'Nid',
        ];
    }
}
