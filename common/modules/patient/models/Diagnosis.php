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

    public static function getListByClassification($classification = 'all')
    {
        $diagnosisList=[];
        $diagnosis = ['Список диагнозов пуст'];

        if ($classification =='all'){
            $diagnosis = self::find()
                ->select(['id','code','Nazv', 'upID'])
                ->asArray()
                ->all();
        }else {
            $diagnosis = self::find()
                ->select(['id','code','Nazv', 'upID'])
                ->where('KlassID=:classification', [':classification' => $classification])
                ->asArray()
                ->all();
        }


        foreach ($diagnosis as $diagnosisItem) {
            foreach ($diagnosis as $diagnosisSub) {
                if ($diagnosisItem['id'] == $diagnosisSub['upID']) {

                    $diagnosisList[$diagnosisItem['code']." ".$diagnosisItem['Nazv']][$diagnosisSub['id']] = $diagnosisSub['code']." ".$diagnosisSub['Nazv'];
                }
            }
        }

        return $diagnosisList;
    }
}