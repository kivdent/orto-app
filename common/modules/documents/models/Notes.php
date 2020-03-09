<?php

namespace common\modules\documents\models;

use common\modules\employee\models\Employee;
use common\modules\patient\models\Patient;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Yii;

class Notes extends \common\models\Notes
{
    const NOTES_TYPE_RECOMMENDATION = 'recommendation';
    const NOTES_TYPE_PRESCRIPTION = 'prescription';
    const NOTES_TYPE_REFERRAL = 'referral';
    const NOTES_TYPE_TEXT = 'text';

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
            'title' => 'Заголовок',
            'type' => 'Тип',
            'text' => 'Содержание',
            'created_at' => 'Создан',
            'updated_at' => 'Изменён',
            'author_id' => 'Автор',
            'patient_id' => 'Пациент',
        ];
    }

    public static function getTypesList()
    {
        $typesList = [
            self::NOTES_TYPE_RECOMMENDATION => 'Рекоммендация',
            self::NOTES_TYPE_PRESCRIPTION => 'Назначение',
            self::NOTES_TYPE_REFERRAL => 'Направление',
            self::NOTES_TYPE_TEXT => 'Заметка',
        ];
        return $typesList;
    }

    public static function getClassesList()
    {
        $typesList = [
            self::NOTES_TYPE_RECOMMENDATION => '\common\modules\catalogs\models\Recommendations',
            self::NOTES_TYPE_PRESCRIPTION => '\common\modules\catalogs\models\Prescriptions',
            self::NOTES_TYPE_REFERRAL => '\common\modules\documents\models\Referral',

        ];
        return $typesList;
    }

    public static function getJsArray($type)
    {
        $arrayScript = 'let textArray=[];';
        foreach (self::getClassesList()[$type]::find()->all() as $item) {
            $arrayScript .= 'textArray[' . $item->id . ']="' . $item->name . '";';
        }
        return $arrayScript;
    }

    public function getAuthorName()
    {
        return $this->employee->fullName;
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'author_id']);
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'patient_id']);
    }

    public function getPatientName()
    {
        return $this->patient->fullName;
    }

    public function getCreatedDate()
    {
        return Yii::$app->formatter->asDate($this->created_at, 'php:d.m.Y');
    }
}