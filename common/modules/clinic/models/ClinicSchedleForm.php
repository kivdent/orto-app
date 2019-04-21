<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\clinic\models;

use common\modules\clinic\models\ClinicSheudles;
use common\modules\clinic\models\DaysInClinicSheudles;
use yii\helpers\ArrayHelper;

/**
 * Description of ClinicSchedleForm
 *
 * @author kivde
 */
class ClinicSchedleForm extends ClinicSheudles {
    /* @var $day[] common\modules\clinic\models\DaysInClinicSheudles */

    public $days;
    public $countDays = 7;

    public function afterFind() {

        $this->days = DaysInClinicSheudles::find()->indexBy('day_number')->where('sheudle_id=' . $this->id)->all();
    }

    public function afterSave($insert, $changedAttributes) {

        foreach ($this->days as &$day) {
            $day->sheudle_id = $this->id;
            $day->save(false);
        }
        return true;
    }

    public function beforeDelete() {
        if (!parent::beforeDelete()) {
            return false;
        }
        $result=true;
        foreach ($this->days as &$day) {

            $result = $day->delete();
        }

        return $result;
    }

    public function createEmptyDays() {
        for ($i = 1; $i <= $this->countDays; $i++) {
            $this->days[$i] = new DaysInClinicSheudles();
            $this->days[$i]->day_number = $i;
            $date = $this->days[$i]->start = date("H:i:s", strtotime('08:00:00'));
            $this->days[$i]->end = date("H:i:s", strtotime('20:00:00'));
            $this->days[$i]->holiday = '0';
        }
    }

}
