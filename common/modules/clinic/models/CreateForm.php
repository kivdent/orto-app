<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\clinic\models;

use yii\base\Model;

/**
 * Description of CreateForm
 *
 * @author kivdent
 */


class CreateForm extends Model {

    /**
     * {@inheritdoc}
     */
    public $name;
    public $address;
    public $phone;
    public $record_phone;
    public $additional_phones;
    public $description;
    public $logo;
    public $requisites;

    public function rules() {
        return [
            [['name'], 'required'],
            [['address', 'requisites'], 'integer'],
            [['additional_phones', 'description'], 'string'],
            [['name', 'phone', 'record_phone', 'logo'], 'string', 'max' => 255],
        ];
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

}
