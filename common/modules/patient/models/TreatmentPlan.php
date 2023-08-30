<?php


namespace common\modules\patient\models;

use common\models\TreatmentPlan as CommonTreatmentPlan;
use common\modules\employee\models\Employee;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use common\modules\patient\models\PlanItem;

class TreatmentPlan extends CommonTreatmentPlan
{
    public function behaviors()
    {
        return [
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

    public function getPlanItems()
    {
        return $this->hasMany(PlanItem::className(), ['plan_id' => 'id']);
    }

    public function getDiagnosis()
    {
        return $this->hasOne(Diagnosis::className(), ['id' => 'diagnosis_id']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Employee::className(), ['id' => 'author']);
    }

    public function getAuthorName()
    {
        return $this->doctor->getFullName();
    }

    public function getPatientInPlan()
    {
        return $this->hasOne(Patient::className(), ['id' => 'patient']);
    }

    public function getPatientName()
    {
        return $this->patientInPlan->fullName;
    }

    public function getDiagnosisTitle()
    {
        $diagnosis = '';
        $diagnosis .= isset($this->diagnosis->code) ? $this->diagnosis->code . " " : "";
        $diagnosis .= isset($this->diagnosis->Nazv) ? $this->diagnosis->Nazv : "";
        return $diagnosis;
    }

    public function getPrice()
    {
        $price_from = 0;
        $price_to = 0;
        foreach ($this->planItems as $planItem) {
            $price_from += isset($planItem->price_from) ? $planItem->price_from : 0;
            $price_to += isset($planItem->price_to) ? $planItem->price_to : 0;
        }
        return $price_from == 0 ? "" : $price_from . "-" . $price_to;
    }
    public function getPriceActual()
    {
        $price_actual = 0;

        foreach ($this->planItems as $planItem) {
            $price_actual += $planItem->price_actual ?? 0;

        }
        return $price_actual == 0 ? "" : $price_actual ;
    }
}