<?php


namespace common\modules\patient\models;


use yii\helpers\ArrayHelper;

class Region extends \common\models\Region
{

    const TYPE_ALL='all';
    const TYPE_JAW='jaw';
    const TYPE_SEGMENT='segment';
    const TYPE_BABY_TOOTH='baby_tooth';
    const TYPE_PERMANENT_TOOTH='permanent_tooth';

    public static function getList(){
        $list=self::find()->asArray()->all();
        $list=ArrayHelper::map($list,'id','title');

        return $list;
    }
    public function isTooth(){
        return ($this->type==self::TYPE_PERMANENT_TOOTH or $this->type==self::TYPE_BABY_TOOTH)? true : false ;
    }
}