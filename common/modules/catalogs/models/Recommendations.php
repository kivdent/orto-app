<?php


namespace common\modules\catalogs\models;


use kartik\tree\models\Tree;

class Recommendations extends Tree
{
public static function tableName()
    {
        return 'recommendations';
    }
    public static  function getArrayScript(){
        $arrayScript='let recommendationsArray=[];';
        foreach (self::find()->all() as $complaints){
            $arrayScript.='recommendationsArray['.$complaints->id.']="'.$complaints->name.'";';
        }
        return $arrayScript;
    }
}