<?php


namespace common\behaviors;


use yii\base\Behavior;

class ActiveBehavior extends Behavior
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function getStatus()
    {
        return $this->active;
    }

    public function getStatusList(){
        return [
            self::STATUS_ACTIVE=>'Активный',
            self::STATUS_INACTIVE=>'Неактивный',
        ];
    }

    public function getStatusName(){
        return $this->statusList[$this->active];
    }
}