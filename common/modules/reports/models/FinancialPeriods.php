<?php


namespace common\modules\reports\models;


class FinancialPeriods extends \common\models\FinancialPeriods
{
    /**
     * This is the model class for table "fin-per".
     *
     * @property int $id
     * @property string $nach
     * @property string $okonch
     * @property int $uet
     */
    const DEFAULT_UET = 100;

    const NOT_DEFINED = 'not_defined';

    public $defined = true;

    public static function getPeriodForDate($date)
    {
        $period = self::find()->where(['<=', 'nach', $date])->andWhere(['>=', 'okonch', $date])->one();
        if (!$period) {
            $period = new FinancialPeriods([
                'defined' => false,
                'nach' => date("Y-m") . "-01",
                'okonch' => date("Y-m") . "-" . date("t"),
                'uet' => self::DEFAULT_UET,
            ]);
        }
        return $period;
    }

    public static function getUETForDate($date)
    {
        return self::getPeriodForDate($date) != self::NOT_DEFINED ? FinancialPeriods::getPeriodForDate($date)->uet : FinancialPeriods::DEFAULT_UET;

    }

    public static function getPeriodForCurrentDate()
    {
        return self::getPeriodForDate(date('Y-m-d'));
    }
}