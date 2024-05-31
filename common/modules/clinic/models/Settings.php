<?php

namespace common\modules\clinic\models;

use common\components\Storage;
use common\modules\userInterface\models\UserInterface;
use Yii;

class Settings extends \common\models\Settings
{
    public $file;

    public static function getWazzupApiKeyValue()
    {
        return Yii::$app->params['wazzup_api_key'];
    }

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public static function getLogoUri()
    {
        $logo = self::getLogo();
        return (Yii::$app->storage->getFileLink($logo->value, '', Storage::TYPE_LOGO) !== null) ?
            Yii::$app->storage->getFileLink($logo->value, '', Storage::TYPE_LOGO) : '';
    }

    public static function getLogo()
    {
        return self::find()->where(['name' => 'logo'])->one();
    }

    public static function getSmsApiKeyValue()
    {
        return self::find()->where(['name' => 'smsApiKey'])->one()->value;
    }

    public static function getYandexDiskTokenValue()
    {
        return self::find()->where(['name' => 'yandexDiskToken'])->one()->value;
    }

    public static function getSmsLogin()
    {
        return Yii::$app->params['sms_login'];
    }

    public static function getSmsPassword()
    {
        return Yii::$app->params['sms_password'];
    }

    public static function getCardArchivePeriod()
    {
        return Yii::$app->params['card_archive_period'] ?? 5;
    }


}