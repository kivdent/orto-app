<?php


namespace common\models;


use yii\db\ActiveRecord;
use Yii;

class FinancialPeriods extends ActiveRecord
{
    /**
     * This is the model class for table "fin-per".
     *
     * @property int $id
     * @property string $nach
     * @property string $okonch
     * @property string $weekends
     * @property int $uet
     */

    public static function tableName()
    {
        return 'fin-per';
    }

    public function rules()
    {
        return [
            [['uet'], 'integer'],
            [['nach', 'okonch','weekends'], 'string'],
            [['uet', 'nach', 'okonch'], 'required'],
            [['weekends'], 'safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uet' => 'Коэффициент',
            'nach' => 'Начало периода',
            'okonch' => 'Окончание периода',
            'weekends' => 'Выходные',
        ];
    }
}