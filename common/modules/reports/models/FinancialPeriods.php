<?php


namespace common\modules\reports\models;


use common\modules\userInterface\models\UserInterface;
use Yii;

class FinancialPeriods extends \common\models\FinancialPeriods
{
    /**
     * This is the model class for table "fin-per".
     *
     * @property int $id
     * @property string $nach
     * @property string $okonch
     * @property int $uet
     * @property string $weekends
     */
    const DEFAULT_UET = 100;

    const NOT_DEFINED = 'not_defined';

    public $defined = true;

    public static function getDefaultWeekends()
    {
        $weekends = '';
        $date = strtotime("01." . date("m.Y"));
        while ($date <= strtotime(date("t.m.Y"))) {
            if (date('N', $date) == 6 or date('N', $date) == 7) {
                $weekends .= ' ' . date('d.m.Y', $date) . ' ;';
            }
            $date = strtotime(date('d.m.Y', $date) . '+1 day');
        }
        return substr($weekends, 0, strlen($weekends) - 2);
    }

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

    public function afterFind()
    {
        $this->nach = Yii::$app->formatter->asDate($this->nach, 'php:d.m.Y');
        $this->okonch = Yii::$app->formatter->asDate($this->okonch, 'php:d.m.Y');
    }

    public function beforeSave($insert)
    {

        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->nach = Yii::$app->formatter->asDate($this->nach, 'php:Y-m-d');
        $this->okonch = Yii::$app->formatter->asDate($this->okonch, 'php:Y-m-d');
        return true;
    }

    public function getWeekendsArray()
    {
        $weekendsArray=[];
        if ($this->weekends){
            foreach (explode(' ; ', $this->weekends) as $value){
//                UserInterface::getVar($value);
                $weekendsArray[]=date('Y-m-d',strtotime($value));
            }
        }

        return $weekendsArray;
    }
}