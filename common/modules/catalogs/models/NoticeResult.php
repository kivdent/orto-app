<?php

namespace common\modules\catalogs\models;
/**
 * @property array $noticeResultList
 */
class NoticeResult extends \common\models\NoticeResult
{
    const NOTICE_RESULT_TURNOUT = 1;
    const NOTICE_RESULT_DID_NOT_ANSWER = 4;
    const NOTICE_RESULT_DID_NOT_CALL = 55555;
    const NOTICE_RESULT_CALL_BACK_LATER = 2;
    const NOTICE_RESULT_WILL_CALL_BACK = 3;
    const NOTICE_RESULT_VISIT_REFUSAL = 6;
    const NOTICE_RESULT_SMS_SENT = 7;


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'RezObzv' => 'Результат уведомления',
        ];
    }

    public static function getNoticeResultList()
    {
        return
            array(
                self::NOTICE_RESULT_TURNOUT => 'Явка подтверждена',
                self::NOTICE_RESULT_DID_NOT_ANSWER => 'Нет ответа',
                self::NOTICE_RESULT_DID_NOT_CALL => 'Не напоминали',
                self::NOTICE_RESULT_CALL_BACK_LATER => 'Перезвонить позже',
                self::NOTICE_RESULT_WILL_CALL_BACK => 'Сам перезвонит',
                self::NOTICE_RESULT_VISIT_REFUSAL => 'Отказ',
                self::NOTICE_RESULT_SMS_SENT => 'Отправлено смс',
            );
    }
}