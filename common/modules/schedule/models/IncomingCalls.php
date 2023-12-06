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


    const BY_RECOMMENDATION = '1';
    const NO_RECOMMENDATION = '0';

    const WITHOUT_DOCTOR = "null";

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
        ];
    }

    public function getByRecommendationLabelList()
    {
        return [
            self::BY_RECOMMENDATION => 'По рекоммендации',
            self::NO_RECOMMENDATION => 'Без рекоммендации',
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
            [['employee_id', 'primary_patient', 'by_recommendation', 'rejection_reasons_id'], 'integer'],
            [['created_at', 'updated_at', 'doctor_id',], 'safe'],
            [['doctor_id', 'call_target'], 'string'],
            [['doctor_id',], 'default', 'value' => NULL],
            [['call_result'], 'string', 'max' => 255],
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