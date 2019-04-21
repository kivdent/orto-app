<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\employee\models\forms;

use common\modules\employee\models\Employee;
use common\modules\userInterface\models\Addresses;
use Yii;

/**
 * Description of EmployeForm
 *
 * @author kivde
 */
class EmployeForm extends Employee {

    public $addressForm;

    public function __construct() {
        $this->addressForm = new Addresses();
        $this->status=self::STATUS_WORKED;
    }

    public function afterFind() {
        parent::afterFind();

        if ($this->address_id !== null) {
            $this->addressForm = Addresses::FindOne($this->address_id);
        } else {
            $this->addressForm = new Addresses();
            $this->addressForm->street = $this->adres;
            $this->addressForm->save(false);
            $this->address_id = $this->addressForm->id;
            $this->save(false);
        }
    }
public function beforeValidate() {
        if (!parent::beforeValidate()) {
            return false;
        }
        $this->dr = isset($this->dr) ? Yii::$app->formatter->asDate($this->dr, 'php:Y-m-d') : '2004-11-11'; //2004-11-11 - значит др не указана

        return true;
    }

    public function beforeSave($insert) {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->addressForm->save()) {
            $this->address_id = $this->addressForm->id;
        } else {
            return false;
        }
        return true;
    }

    public function beforeDelete() {
        if (!parent::beforeDelete()) {
            return false;
        }

        return $this->addressForm->delete() ? true : false;
    }
 
}
