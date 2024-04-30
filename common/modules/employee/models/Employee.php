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
 * @property-read string[] $positionsList
 * @property-read Positions $position
 * @property-read string $addressString
 * @property-read string[] $statusList
 * @property-read Addresses $address
 * @property-read string $full_name
 * @property string $fullName
 * @property-read string $positionName

 */
class Employee extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    const STATUS_WORKED = 'Работает';
    const STATUS_NOT_WORKED = 'Не работает';
    const STATUS_TEMPORARILY_WORKED = 'Временно не работает';
    const STATUS_ALL = 'Все';

    const POSITION_NURSE = 5;
    const POSITION_TECHNICIANS = 8;
    const POSITION_THERAPIST = 1;//Dentist-therapist
    const POSITION_ORTHOPEDIST = 2;//Dentist-orthopedist
    const POSITION_ORTHODONTIST = 3;//Dentist-orthodontist
    const POSITION_REGISTRATOR =4 ;
    const POSITION_ACCOUNTANT =7 ;

//'1', 'Врач стоматолог-терапевт'
//'2', 'Врач стоматолог-ортопед'
//'3', 'Врач стоматолог-ортодонт'
//'4', 'Администратор'
//'5', 'Ассистент врача стоматолога'
//'6', 'Санитар'
//'7', 'Бухгалтер'
//'8', 'Зубной техник'
//'9', 'Гигиенист'
   


    public static function tableName()
    {
        return 'sotr';
    }

    public static function getNursesList()
    {
        return ArrayHelper::map(Employee::find()
            ->select(["id", "CONCAT(surname, ' ', name, ' ',otch) AS full_name"])
            ->where(['dolzh' => self::POSITION_NURSE, 'status' => self::STATUS_WORKED])
            ->orderBy('surname')
            ->asArray()
            ->all(), 'id', 'full_name');
    }

    public static function getTechniciansList()
    {
        return ArrayHelper::map(Employee::find()
            ->select(["id", "CONCAT(surname, ' ', name, ' ',otch) AS full_name"])
            ->where(['dolzh' => self::POSITION_TECHNICIANS, 'status' => self::STATUS_WORKED])
            ->orderBy('surname')
            ->asArray()
            ->all(), 'id', 'full_name');
    }

    public static function getDoctorsList()
    {

        return ArrayHelper::map(Employee::find()
            ->select(["id", "CONCAT(surname, ' ', name, ' ',otch) AS full_name"])
            ->where(['dolzh' => [self::POSITION_THERAPIST, self::POSITION_ORTHOPEDIST, self::POSITION_ORTHODONTIST], 'status' => self::STATUS_WORKED])
            ->orderBy('surname')
            ->asArray()
            ->all(), 'id', 'full_name');
    }
    public static function getWorkedDoctorsList()
    {

        return ArrayHelper::map(Employee::find()
            ->select(["id", "CONCAT(surname, ' ', name, ' ',otch) AS full_name"])
            ->where(['dolzh' => [self::POSITION_THERAPIST, self::POSITION_ORTHOPEDIST, self::POSITION_ORTHODONTIST], 'status' => self::STATUS_WORKED])
            ->andWhere(['status'=>self::STATUS_WORKED])
            ->orderBy('surname')
            ->asArray()
            ->all(), 'id', 'full_name');
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

        return $this->hasOne(Positions::className(), ['id' => 'dolzh']);
    }

    public function getPositionName()
    {
        return $this->position->getName();
    }

    public function getFullName()
    {
        return $this->surname . ' ' . $this->name . ' ' . $this->otch;
    }
    public function getFull_name()
    {
        return $this->surname . ' ' . $this->name . ' ' . $this->otch;
    }

    public function afterFind()
    {

        $this->dr = Yii::$app->formatter->asDate($this->dr, 'php:d.m.Y');
    }

    public function beforeSave($insert)
    {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->dr = Yii::$app->formatter->asDate($this->dr, 'php:Y-m-d');
        return true;
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

        return $this->hasOne(Addresses::className(), ['id' => 'address_id']);
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

//        $list=self::find()->select(["id","CONCAT(surname, ' ', name, ' ',otch) AS full_name"])
//            ->where(['status'=>$status])
//            ->orderBy('surname')
//            ->asArray()
//            ->all();
//
        $list = self::find()->select(["id", "CONCAT(surname, ' ', name, ' ',otch) AS full_name"]);

        if ($status !== self::STATUS_ALL) {
            $list = $list->where(['status' => $status]);

        }
        $list = $list->orderBy('surname')
            ->asArray()
            ->all();


        $list = ArrayHelper::map($list, 'id', 'full_name');

        return $list;
    }

    public static function getEmployeeFullName($id)
    {
        return self::findOne($id)->getFullName();
    }
}
