<?php

namespace common\modules\schedule\models;

use Yii;

/**
 * This is the model class for table "raspis_day".
 *
 * @property int $id
 * @property int $raspis_pack
 * @property int $dayN
 * @property int $rabmestoID
 * @property int $vih
 * @property string $nachPr
 * @property string $okonchPr
 */
class BaseSchedulesDays extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'raspis_day';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['raspis_pack', 'dayN', 'rabmestoID', 'vih'], 'integer'],
            [['nachPr', 'okonchPr'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'raspis_pack' => 'Raspis Pack',
            'dayN' => 'Day N',
            'rabmestoID' => 'Rabmesto I D',
            'vih' => 'Vih',
            'nachPr' => 'Nach Pr',
            'okonchPr' => 'Okonch Pr',
        ];
    }
}
