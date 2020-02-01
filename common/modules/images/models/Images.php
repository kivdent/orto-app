<?php


namespace common\modules\images\models;


use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Yii;

class Images extends \common\models\Images
{
    public $uploadedFile;

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
            'author_id' => 'Автор',
            'patient_id' => 'Пациент',
            'description' => 'Описание',
            'file_name' => 'Файл',
            'created_at' => 'Создан',
            'updated_at' => 'Изменён',
            'uploadedFile' => 'Фотография',
        ];

    }

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['uploadedFile'],  'file',
            'skipOnEmpty' => false,
            'extensions' => ['jpg', 'png'],
            'checkExtensionByMimeType' => true,
            'maxSize' => 1024*1024*10];
//        $rules[] = [['uploadedFile'], 'safe'];

        return $rules;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        echo "<pre>";
        print_r($this->uploadedFile);
        echo "</pre>";
        die();
        return $this->saveUploadedFile();
    }

    private function saveUploadedFile()
    {

        $this->file_name = Yii::$app->storge->saveUploadedFile($this->uploadedFile, $this->getFilePath());
        if (!$this->file_name){
            return false;
        }
        return true;
    }

    private function getFilePath()
    {
        return $this->author_id."/".$this->patient_id."/";
    }

}