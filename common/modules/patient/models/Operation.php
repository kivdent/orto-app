<?php


namespace common\modules\patient\models;


use yii\helpers\ArrayHelper;

class Operation extends \common\models\Operation
{
    public static function getList(){
        $list=self::find()->asArray()->all();
        $list=ArrayHelper::map($list,'id','title');

        return $list;
    }
}