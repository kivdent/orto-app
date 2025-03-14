<?php


namespace common\components;


use common\modules\clinic\models\Settings;
use yii\base\Component;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use Yii;
use Arhitector\Yandex\Disk;

class Storage extends Component
{
    const TYPE_PHOTO = 'photo';
    const TYPE_DOCS = 'docs';
    const TYPE_DOCS_TEMPLATES = 'docs_templates';
    const TYPE_LOGO = 'logo';
    const TYPE_PRICELIST = 'pricelist';
    private $fileName;

    public function saveToYandexDisk($filename, $resourceName)
    {
        $disk = new Disk($this->getYandexDiskToken());
        $resource = $disk->getResource($resourceName);
        $resource->upload($filename, true);
        return true;
    }

    public function getPublicUrl($resourceName)
    {
        $disk = new Disk($this->getYandexDiskToken());
        $resource = $disk->getResource($resourceName);
        $resource->getPublicKey();
        return $resource->getPublicKey() ? $resource->getPublicKey() : '';
    }

    public function saveUploadedFile(UploadedFile $file, $path, $type)
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

        $this->fileName = $this->getFileName($file, $type);


        $path = $this->getStoragePath($type) . $path . $this->fileName;


        $path = FileHelper::normalizePath($path);

        if (FileHelper::createDirectory(dirname($path))) {
            return $path;
        }
    }

    protected function getFilename(UploadedFile $file, $type)
    {
        $name = '';

        if (in_array($type, $this->getTypesWithRandomNames())) {
            $name = uniqid() . "." . $file->extension;
        } else {
            $name = $file->name;
        }
        return $name;
    }

    public function getStoragePath($type)
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

    public function deleteFile($fileName, $path, $type)
    {

        return unlink($this->getStoragePath($type) . $path . $fileName);
    }

    private function getYandexDiskToken()
    {
        return Settings::getYandexDiskTokenValue();
    }

    private function getTypesWithRandomNames()
    {
        return [
            self::TYPE_DOCS_TEMPLATES
        ];
    }
}