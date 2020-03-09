<?php


namespace common\modules\schedule\models\forms;

use common\modules\employee\models\Employee;
use common\modules\schedule\models\BaseSchedules;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use common\modules\schedule\models\forms\BaseScheduleDaysForm;

class BaseScheduleForm extends BaseSchedules
{
    const COUNT_DAYS='7';
    public $scheduleDays = [

    ];

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


    public function setStartValues(){
        $this->start_date=date('d.m.Y');
        $this->appointment_duration=15;
        $this->status=self::STATUS_ACTIVE;
        for($i=1;$i<=self::COUNT_DAYS;$i++){
            $this->scheduleDays[$i]=new BaseScheduleDaysForm();
            $this->scheduleDays[$i]->dayN=$i;
            $this->scheduleDays[$i]->vih=0;
        }

    }


    private function setOldColumns(){
        $this->DateD = $this->start_date;
        $this->vrachID = $this->doctor_id;
        $this->prodpr = $this->appointment_duration;

    }
    public function getEmployeeList(){

        return Employee::getList();
    }
    public function getDurationIntervals(){
        $intervals=[
            '5'=>'5 минут',
            '10'=>'10 минут',
            '15'=>'15 минут',
            '20'=>'20 минут',
            '30'=>'30  минут',
            '60'=>'60  минут',
        ];
        return $intervals;
    }
    public  function getStatusList(){
        return [
          self::STATUS_ACTIVE=>'Активно',
          self::STATUS_INACTIVE=>'Не активно',
        ];
    }
}