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
use yii\base\Model;
use common\interfaces\ClinicInterface;
use common\models\Clinics;

class Clinic extends Model implements ClinicInterface {

    public static function getById($id){}

    /**
     * 
     * получение списка 
     */
    public static function getAll(){}

    /**
     * сохранение
     */
    public function save(){}

    /**
     * удаление
     */
    public function delete(){}

    /**
     * получение идентификатора
     */
    public function getId(){}

    /**
     * Название клиники
     * @return string
     */
    public function getName(){}

    /**
     * Описание клиники
     * @return string
     */
    public function getDescription(){}

    /**
     * Реквизиты клиники
     * @return string
     */
    public function getRequisites(){}

    /**
     * Адрес клиники
     * @return array 
     */
    public function getAddres(){}

    /**
     * Расписание клиники
     * @return array 
     */
    public function getSheudle(){}

    /**
     * Финансовые подразделения клиники
     * @return array 
     */
    public function getFinancialDivisions(){}

    /**
     * Рабочие места клиники
     * @return array 
     */
    public function getWorkplaces(){}

    /**
     * Логотип
     * @return array 
     */
    public function getLogo(){}
}
