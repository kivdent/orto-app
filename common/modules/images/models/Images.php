<?php


namespace common\modules\images\models;


use common\components\Storage;
use common\modules\employee\models\Employee;
use common\modules\patient\models\Patient;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Yii;
use yii\web\UploadedFile;

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
        $rules[] = [['uploadedFile'], 'file',
            'skipOnEmpty' => false,
            'extensions' => ['jpg', 'png', 'jpeg', 'JPG', 'PNG'],
            'checkExtensionByMimeType' => true,
            'maxSize' => 1024 * 1024 * 10];
//        $rules[] = [['uploadedFile'], 'safe'];

        return $rules;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if (!$this->isNewRecord) {
            Yii::$app->storage->deleteFile($this->file_name, $this->getFilePath(), Storage::TYPE_PHOTO);
        }
        return $this->saveUploadedFile();
    }

    public function beforeValidate()
    {
        $this->uploadedFile = UploadedFile::getInstance($this, 'uploadedFile');
        return true;
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        return Yii::$app->storage->deleteFile($this->file_name, $this->getFilePath(), Storage::TYPE_PHOTO);
    }

    private function saveUploadedFile()
    {

        $this->file_name = Yii::$app->storage->saveUploadedFile($this->uploadedFile, $this->getFilePath(), Storage::TYPE_PHOTO);

        if (!$this->file_name) {
            return false;
        }
        return true;
    }

    private function getFilePath()
    {
        return $this->author_id . "/" . $this->patient_id . "/";
    }

    public function getImageLink()
    {
        return (Yii::$app->storage->getFileLink($this->file_name, $this->getFilePath(), Storage::TYPE_PHOTO) !== null) ?
            Yii::$app->storage->getFileLink($this->file_name, $this->getFilePath(), Storage::TYPE_PHOTO) : '';

    }

    public function getAuthorName()
    {
        return $this->employe->fullName;
    }

    public function getEmploye()
    {
        return $this->hasOne(Employee::className(), ['id' => 'author_id']);
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'patient_id']);

    }

    public function getPatientName()
    {
        return $this->patient->fullName;
    }
}