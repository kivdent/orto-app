<?php

namespace common\modules\catalogs\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ds".
 *
 * @property int $id
 * @property string $Nazv
 * @property int $upID
 * @property int $KlassID
 * @property int $Cat
 * @property string $code
 */
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
    public function getDiagnosisName(){
        return $this->code ? $this->code." ".$this->Nazv:$this->Nazv;
    }
}
