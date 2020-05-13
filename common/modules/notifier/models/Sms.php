<?php


namespace common\modules\notifier\models;


use common\modules\patient\models\Patient;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Class Sms
 * @package common\modules\notifier\models
 *
 * @property Patient $patient
 */
class Sms extends \common\models\Sms
{

    const TYPE_APPOINTMENT_NOTIFICATION = 'appointment notification';

    const STATUS_SENT = 'sent';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_UNDELIVERED = 'undelivered';

    private static $typeList = [self::TYPE_APPOINTMENT_NOTIFICATION => 'Напоминание о приёме'];

    private static $statusList = [
        self::STATUS_SENT=>'Отправлено',
        self::STATUS_DELIVERED=>'Доставлено',
        self::STATUS_UNDELIVERED=>'Не доставлено'
    ];

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'patient_id']);
    }
    public static function getTypeList(){
        return self::$typeList;
    }
    public static function getStatusList(){
        return self::$statusList;
    }
}