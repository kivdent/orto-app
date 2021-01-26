<?php


namespace common\modules\archive\models;


use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class ArchivalPatientRecords extends \common\models\ArchivalPatientRecords
{
    public static function getArchiveBoxName($patient_id)
    {
        return self::find()->where(['patient_id'=>$patient_id])!=null?self::find()->where(['patient_id'=>$patient_id])->one()->archive_boxes_id:'Короб не найден';
    }

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
            'created_at' => 'Создана',
            'updated_at' => 'Изменена',
            'archive_boxes_id' => 'Номер архивного короба',
            'patient_id' => 'Пациент',
        ];
    }
}