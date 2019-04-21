<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\clinic\models;

use yii\base\Model;
use Yii;
use yii\web\NotFoundHttpException;

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
    public $phone;
    public $record_phone;
    public $additional_phones;
    public $description;
    public $logo;
    public $requisites_id;
    public $clinic;
    public $address_id;
//adresses
    public $address;
    public $postcode;
    public $city;
    public $street;
    public $house;
    public $apartment;
    //requisites
    public $requisites;
    public $id;
    public $full_name;
    public $OGRN;
    public $INN;
    public $KPP;
    public $legal_address;
    public $OKPO;
    public $OKVED;
    public $checking_account;
    public $correspondent_bank_account;
    public $BIC;
    private $entities = [
        'clinic',
        'addresses',
    ];

    public function rules() {
        return [
            [['name'], 'required'],
            [['address_id', 'requisites_id'], 'integer'],
            [['additional_phones', 'description'], 'string'],
            [['name', 'phone', 'record_phone', 'logo'], 'string', 'max' => 255],
            [['postcode', 'street', 'house'], 'required'],
            [['postcode'], 'integer'],
            [['city'], 'string', 'max' => 25],
            [['street'], 'string', 'max' => 100],
            [['house'], 'string', 'max' => 20],
            [['apartment'], 'string', 'max' => 10],
            [['full_name'], 'string'],
            [['OGRN', 'INN'], 'required'],
            [['OGRN', 'INN', 'KPP', 'legal_address', 'OKPO', 'OKVED', 'checking_account', 'correspondent_bank_account', 'BIC'], 'integer'],
        ];
    }

    public function __construct() {

        $this->clinic = Yii::$app->controller->module->getEntity('clinic');
        $this->address = Yii::$app->controller->module->getEntity('addresses');
        $this->requisites = Yii::$app->controller->module->getEntity('requisites');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'address_id' => 'Адрес',
            'phone' => 'Телефон',
            'record_phone' => 'Телефон регистратуры',
            'additional_phones' => 'Дополнительный телефон',
            'description' => 'Описание',
            'logo' => 'Логотип',
            'requisites' => 'Реквизиты',
            'postcode' => 'Индекс',
            'city' => 'Город',
            'street' => 'Улица',
            'house' => 'Дом',
            'apartment' => 'Квартира',
            'full_name' => 'Полное наименование',
            'OGRN' => 'ОГРН',
            'INN' => 'ИНН',
            'KPP' => 'КПП',
            'legal_address' => 'Юридический адрес',
            'OKPO' => 'ОКПО',
            'OKVED' => 'ОКВЭД',
            'checking_account' => 'Расчетный счет',
            'correspondent_bank_account' => 'Кор счет',
            'BIC' => 'БИК',
        ];
    }

    public static function getById($id) {
        $createForm = new CreateForm();

        $createForm->clinic = $createForm->getEntitysById($id, 'clinic');

        if ($createForm->clinic !== null) {
            $createForm->setAttributes($createForm->clinic->attributes);
            $createForm->address = $createForm->getEntitysById($createForm->address_id, 'addresses');

            if ($createForm->address !== null) {
                $createForm->setAttributes($createForm->address->attributes);
            } 
//            else {
//                $createForm->address = Yii::$app->controller->module->getEntity('addresses');
//            }


            $createForm->requisites = $createForm->getEntitysById($createForm->requisites_id, 'requisites');
            if ($createForm->requisites !== null) {

                $createForm->setAttributes($createForm->requisites->attributes);
            } 
//            else {
//                $createForm->requisites = Yii::$app->controller->module->getEntity('requisites');
//            }
        } else {
            throw new NotFoundHttpException("Не найден id=$id");
        }
//        echo "<pre>";
//        print_r($createForm);
//        echo "</pre>";
        return $createForm;
    }

    public function delete() {
        $this->clinic->delete();
        unset($this->clinic);
        $this->address->delete();
        unset($this->address);
        $this->requisites->delete();
        unset($this->requisites);
        
        return true;
    }

    public function save() {

        $this->clinic->setAttributes($this->attributes);
        $this->address->setAttributes($this->attributes);
        $this->requisites->setAttributes($this->attributes);
        if ($this->address->save()&&$this->requisites->save()) {
            $this->clinic->address_id = $this->address->id;
            $this->clinic->requisites_id= $this->requisites->id;
            if ($this->clinic->save()) {
                $result = true;
            }
        } else {
            $result = false;
        }
        return $result;
    }

    public function getEntitysById($id, $entity) {
        $entitieClass = Yii::$app->controller->module->getEntitysClass($entity);
        $model = $entitieClass::getById($id);

        return $model;
    }

}
