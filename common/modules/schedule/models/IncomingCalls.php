<?php

namespace common\modules\schedule\models;

use common\models\RejectionReasons;
use common\modules\employee\models\Employee;
use common\modules\userInterface\models\UserInterface;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class IncomingCalls extends \common\models\IncomingCalls
{

    const PRIMARY_PATIENT = '1';
    const REPEAT_PATIENT = '0';

    const REFUSAL = 'refusal';
    const APPOINTED = 'appointed';
    const CALL_BACK_LATER = 'call back later';
    const ADDED_TO_CALL_LIST = "added_to_call_list";

    const BY_RECOMMENDATION = '1';
    const NO_RECOMMENDATION = '0';

    const SPECIALIZATION_BITE_CORRECTION='bite_correction';
    const SPECIALIZATION_PROSTHETICS='prosthetics';
    const SPECIALIZATION_THERAPY='therapy';
    const SPECIALIZATION_SURGERY='surgery';
    const SPECIALIZATION_IMPLANTOLOGY='implantology';
    const SPECIALIZATION_JOINT_TREATMENT='joint_treatment';
    const SPECIALIZATION_PERIODONTOLOGY='periodontology';

    const WITHOUT_DOCTOR = "null";

    const COST_YES='yes';
    const COST_NO='no';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'employee_id',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'employee_id',
                ],
                'value' => function ($event) {
                    return UserInterface::getEmployeeId();
                },
            ],
        ];
    }


    public function getPrimaryPatientLabelList()
    {
        return [
            self::PRIMARY_PATIENT => 'Первичный пациент',
            self::REPEAT_PATIENT => 'Првторный пациент',
        ];

    }

    public function getCallResultLabelList()
    {
        return [
            self::REFUSAL => 'Отказ',
            self::APPOINTED => 'Назначен',
            self::CALL_BACK_LATER => 'Перезвонит позже',
            self::ADDED_TO_CALL_LIST => 'Внесён в лист обзвона',
        ];
    }

    public function getByRecommendationLabelList()
    {
        return [
            self::BY_RECOMMENDATION => 'По рекоммендации',
            self::NO_RECOMMENDATION => 'Без рекоммендации',
        ];
    }

    public function getSpecializationLabelList()
    {
        return [
            self::SPECIALIZATION_BITE_CORRECTION=>'Исправление прикуса',
            self::SPECIALIZATION_PROSTHETICS=>'Протезирование',
            self::SPECIALIZATION_THERAPY=>'Терапия',
            self::SPECIALIZATION_SURGERY=>'Хирургия',
            self::SPECIALIZATION_IMPLANTOLOGY=>'Имплантология',
            self::SPECIALIZATION_JOINT_TREATMENT=>'Лечение сустава',
            self::SPECIALIZATION_PERIODONTOLOGY=>'Пародонтология',
        ];
    }
 public function getCostLabelList()
    {
        return [
            self::COST_YES=>'да',
            self::COST_NO=>'нет',
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doctor_id' => 'Врач',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
            'employee_id' => 'Ответственный',
            'primary_patient' => 'Первичный',
            'call_target' => 'Цель звонка',
            'call_result' => 'Результат звонка',
            'by_recommendation' => 'Рекоммендация',
            'rejection_reasons_id' => 'Причина отказа',
            'specialization'=>'Специализация',
            'cost'=>'Вопрос по стоимости',
            'patient_id'=>'Пациент'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Employee::className(), ['id' => 'doctor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['primary_patient', 'call_result', 'rejection_reasons_id'], 'required'],
            [['employee_id', 'primary_patient', 'by_recommendation', 'rejection_reasons_id','patient_id'], 'integer'],
            [['created_at', 'updated_at', 'doctor_id',], 'safe'],
            [['doctor_id', 'call_target'], 'string'],
            [['doctor_id',], 'default', 'value' => NULL],
            [['call_result', 'specialization', 'cost'], 'string', 'max' => 255],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['doctor_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['rejection_reasons_id'], 'exist', 'skipOnError' => true, 'targetClass' => RejectionReasons::className(), 'targetAttribute' => ['rejection_reasons_id' => 'id']],
        ];
    }

    public function getByRecommendation()
    {
        return $this->by_recommendation !== null ? $this->getByRecommendationLabelList()[$this->by_recommendation]:'Не указан';
    }
}