<?php


namespace common\modules\patient\models;

use common\models\TreatmentPlan as CommonTreatmentPlan;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use common\modules\patient\models\PlanItem;

class TreatmentPlan extends CommonTreatmentPlan
{
    public function behaviors() {
        return[
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ]
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
            'author' => 'Доктор',
            'patient' => 'Пациент',
            'comments' => 'Комментарий',
            'deleted' => 'Удалён',
        ];
    }
    public function getPlanItems(){
        return $this->hasMany(PlanItem::className(),['plan_id'=>'id']);
    }
}