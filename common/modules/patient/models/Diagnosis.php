<?php


namespace common\modules\patient\models;


use yii\helpers\ArrayHelper;

class Diagnosis extends \common\models\Diagnosis
{
    public static function getList()
    {
        $diagnosis = ['Список диагнозов пуст'];

        $diagnosis = self::find()->asArray()->all();
        $diagnosis = ArrayHelper::map($diagnosis, 'id', 'Nazv');


        return $diagnosis;
    }
    public static function getListByClassification($classification='all'){
        $diagnosis = ['Список диагнозов пуст'];

        $diagnosis = self::find()->where('KlassID=:classification',[':classification'=>$classification])->asArray()->all();
        $diagnosis = ArrayHelper::map($diagnosis, 'id', 'Nazv');


        return $diagnosis;
    }
}