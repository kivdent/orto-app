<?php

namespace common\modules\clinic\models;

/*
 * Модель работающая с сущногстью clinic
 */

/**
 * Description of clinic
 *
 * @author kivdent
 */

use common\modules\userInterface\models\Addresses;
use common\modules\userInterface\models\Requisites;
use Yii;
use yii\base\Model;
use common\interfaces\ClinicInterface;
use common\models\Clinics;
use yii\db\ActiveRecord;

/**
 *
 * @property-read array $sheudle
 * @property-read \yii\db\ActiveQuery $address
 * @property-read Workplaces $workplaces
 * @property-read FinancialDivisions $financialDivisions
 * @property-read Requisites $requisites
 */
class Clinic extends Clinics //implements ClinicInterface
{

    public static function getById($id)
    {


        return self::findOne($id) !== NULL ? self::findOne($id) : false;
    }

    /**
     *
     * получение списка
     */
    public static function getAll()
    {
        $clinics = self::find()->where('id>0')->all();
        return $clinics !== NULL ? $clinics : false;
    }

    /**
     * @return Clinic
     */
    public static function getMain()
    {
        return self::find()->one();
    }

    public static function getClinicName()

    {
        $clinic = self::getClinicInstance();
        $string = $clinic->requisites->full_name;
        return $string;
    }


    /**
     * @return string
     */
    public static function getDirectorName(): string
    {
        $name = isset(self::getClinicInstance()->director_name) ? self::getClinicInstance()->director_name : 'Корчемный Владимир Маркович';//TODO Брать из БД
        return $name;
    }

    public static function getClinicShortName()
    {
        $name = isset(self::getClinicInstance()->short_name) ? self::getClinicInstance()->short_name : 'ООО "Орто-Премьер НГ"';//TODO Брать из БД
        return $name;
    }

    /**
     * получение идентификатора
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Название клиники
     * @return string
     */
    public function getName()
    {

    }

    /**
     * Описание клиники
     * @return string
     */
    public function getDescription()
    {

    }

    /**
     * Реквизиты клиники
     * @return string
     */
    public function getRequisites()
    {
        return $this->hasOne(Requisites::class, ['id' => 'requisites_id']);
    }

    public static function getRequisitesString()
    {

        return true;
    }

    /**
     * Адрес клиники
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Addresses::class, ['id' => 'address_id']);
    }

    /**
     * Расписание клиники
     * @return array
     */
    public function getSheudle()
    {

    }

    /**
     * Финансовые подразделения клиники
     * @return array
     */
    public function getFinancialDivisions()
    {

    }

    /**
     * Рабочие места клиники
     * @return array
     */
    public function getWorkplaces()
    {

    }

    /**
     * Логотип
     * @return array
     */
    public function getLogo()
    {

    }

    static function hasClinics()
    {
        return self::getAll();
    }

    public static function getClinicInfoString()
    {
        $clinic = self::getClinicInstance();
        $address = $clinic->address;
        $string = "г. " . $address->city . ", ул. " . $address->street . " " . $address->house . "-" . $address->apartment . "<br>";
        $string .= $clinic->phone;

        return $string;
    }

    /**
     * @return Clinic
     */
    public static function getClinicInstance(): Clinic
    {
        return self::find()->all()[0];
    }

    public static function getAddressStringForSms()
    {
        $clinic = self::getClinicInstance();
        $address = $clinic->address;
        $string = "ул. " . $address->street . " д." . $address->house;
        return $string;
    }
}
