<?php

namespace frontend\models;

use Yii;

use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "sotr".
 *
 * @property int $id
 * @property string $surname
 * @property string $name
 * @property string $otch
 * @property string $dr
 * @property string $dtel
 * @property string $mtel
 * @property string $adres
 * @property int $dolzh
 */
class Employe extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'sotr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['dr'], 'safe'],
            [['name', 'otch', 'surname'], 'required'],
            [['adres'], 'string'],
            [['dolzh'], 'integer'],
            [['surname'], 'string', 'max' => 25],
            [['name', 'otch', 'dtel', 'mtel'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'otch' => 'Отчество',
            'dr' => 'День рождения',
            'dtel' => 'Домашний телефон',
            'mtel' => 'Мобильный телефон',
            'adres' => 'Адрес',
            'dolzh' => 'Должность',
        ];
    }


    public function getFullName() {
        return $this->surname . " " . $this->name . " " . $this->otch;
    }
    public static function getList() {
       
        return  ArrayHelper::map(self::find()->orderBy('surname')->all(), 'id', 'fullName');
    }
}
