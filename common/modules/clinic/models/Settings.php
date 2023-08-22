<?php

namespace common\modules\clinic\models;

use common\components\Storage;
use Yii;

class Settings extends \common\models\Settings
{
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public static function getLogoUri()
    {
        $logo=self::getLogo();
        return (Yii::$app->storage->getFileLink($logo->value, '', Storage::TYPE_LOGO) !== null) ?
        Yii::$app->storage->getFileLink($logo->value, '', Storage::TYPE_LOGO) : '';
    }
    public static function getLogo(){
        return self::find()->where(['name'=>'logo'])->one();
    }
    public static function getSmsApiKeyValue(){
        return self::find()->where(['name'=>'smsApiKey'])->one()->value;
    }
    public static function getYandexDiskTokenValue(){
        return self::find()->where(['name'=>'yandexDiskToken'])->one()->value;
    }
}