<?php


namespace common\modules\catalogs\models;


use kartik\tree\models\Tree;

class Anamnesis extends Tree
{
    public static function tableName()
    {
        return 'anamnesis';
    }
    public static  function getArrayScript(){

        $arrayScript='let anamnesisArray=[];';
        foreach (self::find()->all() as $item){
            $arrayScript.='anamnesisArray['.$item->id.']="'.$item->name.'";';
        }
        return $arrayScript;
    }
}