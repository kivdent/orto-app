<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sms".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $patient_id
 * @property string $phone
 * @property int $sms_id
 * @property string $status
 * @property string $type
 * @property string $text
 */
class Sms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['patient_id', 'sms_id'], 'integer'],
            [['text'], 'string'],
            [['phone', 'status', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
            'patient_id' => 'Пациент',
            'phone' => 'Телефон',
            'sms_id' => 'Идентификатор смс',
            'status' => 'Статус',
            'type' => 'Тип',
            'text' => 'Текст',
        ];
    }
}
