<?php


namespace common\modules\patient\models;

use common\models\TreatmentPlan as CommonTreatmentPlan;
use common\modules\employee\models\Employee;
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
            'author' => 'Врач',
            'patient' => 'Пациент',
            'comments' => 'Комментарий',
            'deleted' => 'Удалён',
            'diagnosis_id' => 'Диагноз',
        ];
    }
    public function getPlanItems(){
        return $this->hasMany(PlanItem::className(),['plan_id'=>'id']);
    }
    public function getDiagnosis(){
        return $this->hasOne(Diagnosis::className(),['id'=>'diagnosis_id']);
    }
    public function getDoctor(){
        return $this->hasOne(Employee::className(),['id'=>'author']);
    }
    public function getAuthorName(){
        return $this->doctor->getFullName();
    }
    public function getPatientInPlan(){
        return $this->hasOne(Patient::className(),['id'=>'patient']);
    }
    public function getPatientName(){
        return $this->patientInPlan->fullName;
    }
}