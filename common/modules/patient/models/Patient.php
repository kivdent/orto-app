<?php

namespace common\modules\patient\models;

use Yii;
use common\modules\userInterface\models\Addresses;

/**
 * This is the model class for table "klinikpat".
 *
 * @property double $id
 * @property string $surname+
 * @property string $name+
 * @property string $otch+
 * @property string $dr +
 * @property string $sex+
 * @property string $adres+
 * @property string $MestRab+
 * @property string $prof+
 * @property string $email+
 * @property string $DTel+
 * @property string $RTel+
 * @property string $MTel+
 * @property string $FLech+
 * @property int $Skidka+
 * @property string $Prim+
 * @property string $address_id +
 */
class Patient extends \yii\db\ActiveRecord {

    const SEX_MALE = 'Муж';
    const SEX_FEMALE = 'Жен';
    const SEX_NOT_SET = '';

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'klinikpat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
      return [
            [['dr'], 'safe'],
            [['Skidka', 'address_id'], 'integer'],
          
            [['Prim'], 'string'],
            [['surname'], 'string', 'max' => 20],
            [['name', 'otch', 'MestRab', 'prof', 'DTel', 'RTel', 'MTel', 'FLech'], 'string', 'max' => 15],
            [['sex'], 'string', 'max' => 5],
            [['adres'], 'string', 'max' => 255],
            [['email'], 'email',],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'Карта',
            'surname' => 'Фимилия',
            'name' => 'Имя',
            'otch' => 'Отчество',
            'dr' => 'Дата рождения',
            'sex' => 'Пол',
            'adres' => 'Адрес',
            'MestRab' => 'Место работы',
            'prof' => 'Профессия',
            'email' => 'Электронная почта',
            'DTel' => 'Домашний телефон',
            'RTel' => 'Рабочий телефон',
            'MTel' => 'Мобильный телефон',
            'FLech' => 'Форма лечения',
            'Skidka' => 'Скидка',
            'Prim' => 'Примечание',
        ];
    }

    public function afterFind() {
        
        $this->dr=Yii::$app->formatter->asDate($this->dr,'php:d.m.Y');
    }

    public function getSex() {
        return $this->sex;
    }

    public function getSexList() {
        return[
            self::SEX_FEMALE => 'Женский',
            self::SEX_MALE => 'Мужской',
            self::SEX_NOT_SET => 'Не выбран',
        ];
    }
public function getAddress() {

        return $this->hasOne(Addresses::class, ['id' => 'address_id']);
    }
    public function getAddressString() {
        if ($this->address !== null) {
            $address = $this->address->addressString;
        } else {
            $address = $this->adres;
        }
        return $address;
    }

    public function getFullName() {
        return $this->surname . " " . $this->name . " " . $this->otch;
    }

    public function getId() {
        return $this->id;
    }

}