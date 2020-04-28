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

class Clinic extends Clinics implements ClinicInterface {

    public static function getById($id) {


        return self::findOne($id) !== NULL ? self::findOne($id) : false;
    }

    /**
     * 
     * получение списка 
     */
    public static function getAll() {
        $clinics=self::find()->where('id>0')->all();
        return $clinics !== NULL ? $clinics : false;
    }

    public static function getMain()
    {
        return self::find()->one();
    }

    /**
     * получение идентификатора
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Название клиники
     * @return string
     */
    public function getName() {
        
    }

    /**
     * Описание клиники
     * @return string
     */
    public function getDescription() {
        
    }

    /**
     * Реквизиты клиники
     * @return string
     */
    public function getRequisites() {
        
    }

    /**
     * Адрес клиники
     * @return array 
     */
    public function getAddres() {
        
    }

    /**
     * Расписание клиники
     * @return array 
     */
    public function getSheudle() {
        
    }

    /**
     * Финансовые подразделения клиники
     * @return array 
     */
    public function getFinancialDivisions() {
        
    }

    /**
     * Рабочие места клиники
     * @return array 
     */
    public function getWorkplaces() {
        
    }

    /**
     * Логотип
     * @return array 
     */
    public function getLogo() {
        
    }
    static function hasClinics(){
        return self::getAll();
    }
   

}
