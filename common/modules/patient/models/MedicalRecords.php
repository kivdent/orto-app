<?php


namespace common\modules\patient\models;


use common\modules\employee\models\Employee;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use common\modules\catalogs\models\Diagnosis;
use common\modules\patient\models\Region;
use yii\helpers\ArrayHelper;

class MedicalRecords extends \common\models\MedicalRecords
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

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->date = Yii::$app->formatter->asDate($this->date, 'php:Y-m-d');
        return true;
    }

    public function rules()
    {
        $rules=parent::rules();
        $rules[]=[['region_id', 'diagnosis_id'], 'required'];
        return $rules;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => 'Область',
            'diagnosis_id' => 'Диагноз',
            'complaints' => 'Жалобы',
            'anamnesis' => 'Анамнез',
            'objectively' => 'Объективно',
            'recommendations' => 'Рекоммендации',
            'prescriptions' => 'Назначения',
            'invoice_id' => 'Счет',
            'therapy' => 'Лечение',
            'created_at' => 'Создана',
            'updated_at' => 'Изменена',
            'date' => 'Дата',
            'employe_id' => 'Врач',
            'patient_id' => 'Пациент',
        ];
    }

    public function getEmployeName()
    {
        return $this->employe->getFullName();
    }

    public function getEmploye()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employe_id']);
    }

    public function getRegionName()
    {
        return isset($this->region->title) ? $this->region->title : "Не указана";
    }

    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    public function getDiagnosisName()
    {
        return $this->diagnosis !== null ? $this->diagnosis->getDiagnosisName() : "Не определён";
    }

    public function getDiagnosis()
    {
        return $this->hasOne(Diagnosis::className(), ['id' => 'diagnosis_id']);
    }

    public function getFormattedDate()
    {
        return Yii::$app->formatter->asDate($this->date, 'php:d.m.Y');
    }

    public function getPatientName()
    {
        return $this->patient->getFullName();
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'patient_id']);
    }

    public static function getDoctorListForPatient($patient_id)
    {
        $list=[];
        $medicalRecords = self::find()
            ->select('employe_id')
            ->where('patient_id=:patient_id', [':patient_id' => $patient_id])
            ->groupBy('employe_id')
            ->all();
        foreach ($medicalRecords as $item){
            $list[$item->employe_id]=$item->getEmployeName();
        }
        return $list;
    }
 public static function getRegionListForPatient($patient_id)
    {
        $list=[];
        $medicalRecords = self::find()
            ->select('region_id')
            ->where('patient_id=:patient_id', [':patient_id' => $patient_id])
            ->groupBy('region_id')
            ->all();

        foreach ($medicalRecords as $item){
            $list[$item->region_id]=$item->getRegionName();
        }
        return $list;
    }

}