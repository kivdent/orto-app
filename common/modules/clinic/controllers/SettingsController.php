<?php

namespace common\modules\clinic\controllers;

use common\components\Storage;
use common\modules\clinic\models\Settings;
use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\web\UploadedFile;

class SettingsController extends \yii\web\Controller
{
    public $clinic_id;

    public function beforeAction($action)
    {
        if (Yii::$app->request->get('clinic_id') !== null) {
            $this->clinic_id = Yii::$app->request->get('clinic_id');
        }
        return true;

    }

    public function actionIndex()
    {
        return $this->render('index',['clinic_id'=>$this->clinic_id]);
    }

    public function actionSet()
    {

        $logo = Settings::find()->where(['name' => 'logo'])->one();
        $smsApiKey = Settings::find()->where(['name' => 'smsApiKey'])->one();
        $yandexDiskToken = Settings::find()->where(['name' => 'yandexDiskToken'])->one();


        $smsApiKey->value = Yii::$app->request->post('smsApiKey');
        $yandexDiskToken->value = Yii::$app->request->post('yandexDiskToken');

        $smsApiKey->save(false);
        $yandexDiskToken->save(false);

        $logo->load(Yii::$app->request->post(), '');
        if ($logo->file !== null) {
            $logo->file = UploadedFile::getInstanceByName('file');
            $logo->value = Yii::$app->storage->saveUploadedFile($logo->file, '', Storage::TYPE_LOGO);
            $logo->save(false);
        }


        return $this->redirect(['index','clinic_id'=>$this->clinic_id]);
    }
}