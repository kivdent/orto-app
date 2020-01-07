<?php


namespace common\modules\catalogs\models;
use kartik\tree\models\Tree;



class Complaints extends Tree
{
    //use TreeTrait;

    public static function tableName()
    {
        return 'complaints';
    }
    public static  function getArrayScript(){
        $arrayScript='let complaintsArray=[];';
        foreach (self::find()->all() as $complaints){
            $arrayScript.='complaintsArray['.$complaints->id.']="'.$complaints->name.'";';
        }
        return $arrayScript;
    }
}