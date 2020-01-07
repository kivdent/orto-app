<?php


namespace common\modules\catalogs\models;


use kartik\tree\models\Tree;

class Prescriptions extends Tree
{
    public static function tableName()
    {
        return 'prescriptions';
    }
    public static  function getArrayScript(){
        $arrayScript='let prescriptionsArray=[];';
        foreach (self::find()->all() as $complaints){
            $arrayScript.='prescriptionsArray['.$complaints->id.']="'.$complaints->name.'";';
        }
        return $arrayScript;
    }
}
{

}