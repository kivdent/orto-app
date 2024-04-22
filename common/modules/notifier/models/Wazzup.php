<?php

namespace common\modules\notifier\models;

use common\modules\clinic\models\Settings;
use common\modules\userInterface\models\UserInterface;
use yii\base\Model;

class Wazzup extends Model
{
    public static function getUser()
    {
        $url = "https://api.wazzup24.com/v3/users";

        $data = [
            'id' => '1',
            'name' => 'Владимир'
        ];

        $result = self::sendRequest($url, $data, 'GET');

        return $result;
    }

    public static function addUser()
    {
        $url = "https://api.wazzup24.com/v3/users";

        $data = [
            [
                'id' => 1,
                'name' => 'Vladimir'
            ]
        ];

        $result = self::sendRequest($url, $data);

        return $result;
    }

    private static function getApiKey()
    {
        return Settings::getWazzupApiKeyValue();
    }

    private static function sendRequest(string $url, array $data, string $method = 'POST', string $header = "default", array $options = [])
    {

// use key 'http' even if you send the request to https://...
        if ($header == "default") {
            //$header = self::getHeaderWithApi();
            $header = "Authorization: Bearer 3eaa202b245649d7806c836a0ba0bf86\r\n Content-Type: application/json\r\n";
            //  $header =  "Authorization: Bearer 3eaa202b245649d7806c836a0ba0bf86";
        }

        $options = array(
            'http' => array(
                'header' => $header,
                'method' => $method,
                //'content' => http_build_query($data),
                'content' => [json_encode($data, JSON_UNESCAPED_UNICODE)],
                'ignore_errors' => 1
            )
        );

        $context = stream_context_create($options);
        //UserInterface::getVar($options);
        $result = file_get_contents("https://api.wazzup24.com/v3/users", false, $context);

        if ($result === FALSE) { /* Handle error */
        }
        return $result;
    }

    public static function sendPost()
    {
        $data = array(
            [
                'id' => '1',
                'name' => 'Vladimir',
                'phone' => '79609074044'
            ]
        );

        $ch = curl_init('https://api.wazzup24.com/v3/users');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer 3eaa202b245649d7806c836a0ba0bf86'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, JSON_UNESCAPED_UNICODE));//
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);

        $result = $res;

        return $result;
    }

    public static function sendGet()
    {
        $ch = curl_init('https://api.wazzup24.com/v3/channels');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer 3eaa202b245649d7806c836a0ba0bf86'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private static function getHeaderWithApi()
    {
        return "Authorization: Bearer " . +self::getApiKey();
    }
}