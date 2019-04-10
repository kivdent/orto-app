<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\clinic\models;

use yii\base\Model;
use Yii;

/**
 * Description of CreateForm
 *
 * @author kivdent
 */
class CreateForm extends Model {
    /**
     * {@inheritdoc}
     */

    /**
     *
     * @var $clinic common\modules\clinic\models\Clinics;
     */
    public $name;
    public $address;
    public $phone;
    public $record_phone;
    public $additional_phones;
    public $description;
    public $logo;
    public $requisites;
    public $clinic;

    public function rules() {
        return [
            [['name'], 'required'],
            [['address', 'requisites'], 'integer'],
            [['additional_phones', 'description'], 'string'],
            [['name', 'phone', 'record_phone', 'logo'], 'string', 'max' => 255],
        ];
    }

    public function __construct() {

        $this->clinic = Yii::$app->controller->module->getEntitie('clinic');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'record_phone' => 'Телефон регистратуры',
            'additional_phones' => 'Дополнительный телефон',
            'description' => 'Описание',
            'logo' => 'Логотип',
            'requisites' => 'Реквизиты',
        ];
    }

    public static function getById($id) {
        $createForm = new CreateForm();
        $createForm->clinic = $createForm->getEntitiesById($id, 'clinic');
        $createForm->setAttributes($createForm->clinic->attributes);
        return $createForm;
    }

    public function delete() {
        $this->clinic->delete();
        unset($this->clinic);
        return true;
    }

    public function save() {
        $entityClass = Yii::$app->controller->module->getEntitiesClass('clinic');
        $clinic = new $entityClass;
        $clinic->setAttributes($this->attributes);

        if ($clinic->save()) {
            $this->clinic = $clinic;
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function getEntitiesById($id, $entity) {
        $entitieClass = Yii::$app->controller->module->getEntitiesClass($entity);
        $model = $entitieClass:: getById($id);
        return $model:: getById($id);
    }

}
