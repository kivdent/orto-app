<?php


namespace common\components;


use common\modules\clinic\models\Clinic;
use common\modules\clinic\models\Settings;
use common\modules\schedule\models\Appointment;
use Yii;
use yii\base\Component;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Json;
use common\modules\notifier\models\Sms;

class SmsNotifier extends Component
{
    const AUTH_TYPE_KEY = 'key';
    const AUTH_TYPE_LOGIN = 'login';

    public static function sendAppointmentNotification($appointment_id)
    {
        $appointment = Appointment::findOne($appointment_id);
        if (YII_ENV_DEV) {
            $phone = "+79609074044";
        } else {
            $phone = self::getPhoneFromAppointment($appointment);
        }
        $text = self::getAppointmentNotificationText($appointment);
        $result = self::sendSms($phone, $text);
        $result = Json::decode($result);
        if ($result['response']['msg']['err_code']) {
            if ($result['response']['msg']['err_code'] == '627') {

                $result = self::sendSms($phone, $text, self::AUTH_TYPE_LOGIN);
                $result = Json::decode($result);
                if ($result['response']['msg']['err_code']) {
                    return $result['response']['msg']['err_code'];
                } else {
                    $sms = new Sms(
                        [
                            'phone' => $phone,
                            'text' => $text,
                            'patient_id' => $appointment->PatID,
                            'type' => Sms::TYPE_APPOINTMENT_NOTIFICATION,
                            'status' => Sms::STATUS_SENT,
                            'sms_id' => $result['response']['data']['id'],
                        ]
                    );

                    $sms->save(false);
                    $appointment->RezObzv = Appointment::SMS_SENT;
                    $appointment->save(false);

                }
            }
            return $result['response']['msg']['err_code'];
        } else {
            $sms = new Sms(
                [
                    'phone' => $phone,
                    'text' => $text,
                    'patient_id' => $appointment->PatID,
                    'type' => Sms::TYPE_APPOINTMENT_NOTIFICATION,
                    'status' => Sms::STATUS_SENT,
                    'sms_id' => $result['response']['data']['id'],
                ]
            );

            $sms->save(false);
            $appointment->RezObzv = Appointment::SMS_SENT;
            $appointment->save(false);
        }

        return $result;
    }

    private static function sendSms($phone, $text, $authType = self::AUTH_TYPE_KEY)
    {
        $url = 'https://ssl.bs00.ru';

        $data = [
            'method' => 'push_msg',
            'format' => 'json',
            //'key' => self::getApiKey(),
            'text' => $text,
            'phone' => $phone,
            'sender_name' => 'OrtoPremier'
        ];
        if ($authType == self::AUTH_TYPE_KEY) {
            $data['key'] = self::getApiKey();
        } elseif ($authType == self::AUTH_TYPE_LOGIN) {
            $data['email'] = Settings::getSmsLogin();
            $data['password'] = Settings::getSmsPassword();
        }

// use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { /* Handle error */
        }
        return $result;
    }

    private static function getPhoneFromAppointment(Appointment $appointment)
    {
        $phone = UserInterface::getNormalizedPhone($appointment->patient->MTel);
        return $phone;
    }

    private static function getAppointmentNotificationText(Appointment $appointment)
    {
        $text = 'Здравствуйте, напоминаем, что вы назначены на приём '
            . UserInterface::getFormatedDate($appointment->appointments_day->date)
            . ' в '
            . substr($appointment->NachNaz, 0, 5)
            . ' в стоматологическую клинику Орто-Премьер, по адресу '
            . Clinic::getAddressStringForSms();
        return $text;
    }

    private static function getApiKey()
    {
        return Settings::getSmsApiKeyValue();
    }
}