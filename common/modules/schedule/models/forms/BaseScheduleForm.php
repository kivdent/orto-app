<?php


namespace common\modules\schedule\models\forms;


use common\modules\schedule\models\BaseSchedules;
use common\modules\schedule\models\BaseSchedulesDays;
use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;


class BaseScheduleForm extends BaseSchedules
{
    const COUNT_DAYS = '7';
    public $scheduleDays;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }


    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }
        $this->start_date = isset($this->start_date) ? Yii::$app->formatter->asDate($this->start_date, 'php:Y-m-d') : date('Y-m-d');
        $this->setOldColumns();//TODO Удалить после прехода на новые таблицы

        return true;
    }


    public function setStartValues()
    {
        $this->start_date = date('d.m.Y');
        $this->appointment_duration = 15;
        $this->status = self::STATUS_ACTIVE;
        for ($i = 1; $i <= self::COUNT_DAYS; $i++) {
            $this->scheduleDays[$i] = new BaseSchedulesDays();
            $this->scheduleDays[$i]->dayN = $i;
            $this->scheduleDays[$i]->vih = 0;
        }
    }

    private function setOldColumns()
    {
        $this->DateD = $this->start_date;
        $this->vrachID = $this->doctor_id;
        $this->prodpr = $this->appointment_duration;
    }


}