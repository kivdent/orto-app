<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "medical_records".
 *
 * @property int $id
 * @property int $region_id
 * @property int $diagnosis_id
 * @property string $complaints
 * @property string $anamnesis
 * @property string $objectively
 * @property string $recommendations
 * @property string $prescriptions
 * @property int $invoice_id
 * @property string $therapy
 * @property string $created_at
 * @property string $updated_at
 * @property string $date
 * @property int $employe_id
 * @property int $patient_id
 */
class MedicalRecords extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medical_records';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id', 'diagnosis_id', 'invoice_id', 'employe_id', 'patient_id'], 'integer'],
            [['complaints', 'anamnesis', 'objectively', 'recommendations', 'prescriptions', 'therapy'], 'string'],
            [['created_at', 'updated_at', 'date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => 'Region ID',
            'diagnosis_id' => 'Diagnosis ID',
            'complaints' => 'Complaints',
            'anamnesis' => 'Anamnesis',
            'objectively' => 'Objectively',
            'recommendations' => 'Recommendations',
            'prescriptions' => 'Prescriptions',
            'invoice_id' => 'Invoice ID',
            'therapy' => 'Therapy',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'date' => 'Date',
            'employe_id' => 'Employe ID',
            'patient_id' => 'Patient ID',
        ];
    }
}
