<?php


namespace common\modules\catalogs\models;


use kartik\tree\models\Tree;

class Therapy extends Tree
{

    public static function tableName()
    {
        return 'therapy';
    }
    public static  function getArrayScript(){
        $arrayScript='let therapyArray=[];';
        foreach (self::find()->all() as $complaints){
            $arrayScript.='therapyArray['.$complaints->id.']="'.$complaints->name.'";';
        }
        return $arrayScript;
    }

}