<?php


namespace common\components;


use yii\base\Component;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use Yii;

class Storage extends Component
{
    const TYPE_PHOTO = 'photo';

    private $fileName;


    public function saveUploadedFile(UploadedFile $file, $path = '', $type)
    {
        $path = $this->preparePath($file, $path, $type);

        if ($path && $file->saveAs($path)) {
            return $this->fileName;
        } else {
            return false;
        }

    }

    protected function preparePath(UploadedFile $file, $path, $type)
    {
        $this->fileName = $this->getFileName($file);


        $path = $this->getStoragePath($type) . $path . $this->fileName;


        $path = FileHelper::normalizePath($path);

        if (FileHelper::createDirectory(dirname($path))) {
            return $path;
        }
    }

    protected function getFilename(UploadedFile $file)
    {

        return $file->name;
    }

    protected function getStoragePath($type)
    {
        return Yii::getAlias(Yii::$app->params[$type . '_path']);

    }

    public function getStorageUri($type)
    {
        return Yii::$app->params[$type . '_uri'];
    }

    public function getFileLink($fileName, $path, $type)
    {
        return $this->getStorageUri($type) . $path . $fileName;
    }
    public function deleteFile($fileName, $path, $type){

        return unlink( $this->getStoragePath($type) . $path . $fileName);
    }
}