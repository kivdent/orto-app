<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\abstractClasses;
use common\interfaces\EntitiesInterface;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
/**
 * Description of ActiveRecordEntity
 *
 * @author kivde
 */
class ActiveRecordEntity extends ActiveRecord implements EntitiesInterface{

/**
 * Получение экземпляра по идентификатору
 * @param type $id
 */
public static function getById($id){
    $result=self::findOne($id);
    if ($result==null){
        throw new NotFoundHttpException("Не найденобъект с id=$id");
    }
return $result;
}
/**
 * 
 * получение списка 
 */
public static function getAll(){
   $result=self::find()->where('id>0')->all();
       
    if ($result==null){
        throw new NotFoundHttpException("Не найдено ни одного экземпляра");
    }
return $result;
}

public function getId(){
    return $this->getPrimaryKey();
}


}
