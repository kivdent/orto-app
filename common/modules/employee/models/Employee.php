<?php

namespace common\modules\employee\models;

use Yii;
use common\modules\catalogs\modules\positions\models\Positions;
use common\modules\userInterface\models\Addresses;
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
 * @property int $address_id
 * @property int $status
 */
class Employee extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    const STATUS_WORKED = 'Работает';
    const STATUS_NOT_WORKED = 'Не работает';
    const STATUS_TEMPORARILY_WORKED = 'Временно не работает';

    public static function tableName()
    {
        return 'sotr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dr'], 'safe'],
            [['status'], 'string'],
            [['adres'], 'string'],
            [['dolzh'], 'integer'],
            [['address_id'], 'integer'],
            [['surname'], 'string', 'max' => 25],
            [['name', 'otch', 'dtel', 'mtel'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'otch' => 'Отчество',
            'dr' => 'Дата рождения',
            'dtel' => 'Домашний телефон',
            'mtel' => 'Мобильный телефон',
            'adres' => 'Адрес',
            'dolzh' => 'Должность',
            'status' => 'Статус',
        ];
    }

    public function getPosition()
    {

        return $this->hasOne(Positions::class, ['id' => 'dolzh']);
    }

    public function getPositionName()
    {
        return $this->position->getName();
    }

    public function getFullName()
    {
        return $this->surname . ' ' . $this->name . ' ' . $this->otch;
    }

    public function afterFind()
    {

        $this->dr = Yii::$app->formatter->asDate($this->dr, 'php:d.m.Y');
    }

    public function getPositionsList()
    {

        return Positions::getList();
    }

    public function getAddressString()
    {
        if ($this->address !== null) {
            $address = $this->address->addressString;
        } else {
            $address = $this->adres;
        }
        return $address;
    }

    public function getAddress()
    {

        return $this->hasOne(Addresses::class, ['id' => 'address_id']);
    }

    public function getStatusList()
    {
        return [
            self::STATUS_NOT_WORKED => self::STATUS_NOT_WORKED,
            self::STATUS_WORKED => self::STATUS_WORKED,
            self::STATUS_TEMPORARILY_WORKED => self::STATUS_TEMPORARILY_WORKED,
        ];
    }

    public static function getList($status = self::STATUS_WORKED)
    {

        $list=self::find()->select(["id","CONCAT(surname, ' ', name, ' ',otch) AS full_name"])
            ->where(['status'=>$status])
            ->orderBy('surname')
            ->asArray()
            ->all();
        $list=ArrayHelper::map($list,'id','full_name');

        return $list;
    }
    public static function getEmployeeFullName($id)
    {

    }
}
