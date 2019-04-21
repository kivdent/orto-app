<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\patient\models\forms;

use common\modules\patient\models\Patient;
use common\modules\userInterface\models\Addresses;
use Yii;

/**
 * Description of PatientForm 
 *
 * @author kivde
 */
/* @var  $forms['patient'] common\modules\patient\models\Patient */

class PatientForm extends Patient {

    public $addressForm;

    public function __construct($config = array()) {
        $this->addressForm = new Addresses();
        $this->sex = self::SEX_NOT_SET;
    }

    public function afterFind() {
        parent::afterFind();

        if ($this->address_id !== null) {
            $this->addressForm = Addresses::FindOne($this->address_id);
        } else {
            $this->addressForm = new Addresses();
            $this->addressForm->street = $this->adres;
            $this->addressForm->save(false);
            $this->address_id= $this->addressForm->id;
            $this->save(false);
        }
    }

    public function beforeValidate() {
        if (!parent::beforeValidate()) {
            return false;
        }
        $this->dr = isset($this->dr) ? Yii::$app->formatter->asDate($this->dr, 'php:Y-m-d') : '2004-11-11'; //2004-11-11 - значит др не указана
        $this->surname = mb_strtoupper($this->surname);
        $this->name = mb_strtoupper($this->name);
        $this->otch = mb_strtoupper($this->otch);
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
