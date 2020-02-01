<?php


namespace common\components;


use yii\base\Component;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class Storage extends Component
{
    private $fileName;
    private $path;

    public function saveUploadedFile(UploadedFile $file, $path)
    {
        $path = $this->preparePath($path);

        if ($path && $file->saveAs($path)) {
            return $this->fileName;
        } else {
            return false;
        }

    }

    protected function preparePath(UploadedFile $file)
    {
        $this->fileName = $this->getFileName($file);
        //     0c/a9/277f91e40054767f69afeb0426711ca0fddd.jpg

        $path = $this->getStoragePath() . $this->fileName;


        $path = FileHelper::normalizePath($path);
        if (FileHelper::createDirectory(dirname($path))) {
            return $path;
        }
    }

    protected function getFilename(UploadedFile $file)
    {
        // $file->tempname   -   /tmp/qio93kf

        $hash = sha1_file($file->tempName); // 0ca9277f91e40054767f69afeb0426711ca0fddd

        $name = substr_replace($hash, '/', 2, 0);
        $name = substr_replace($name, '/', 5, 0);  // 0c/a9/277f91e40054767f69afeb0426711ca0fddd
        return $name . '.' . $file->extension;  //0c/a9/277f91e40054767f69afeb0426711ca0fddd.jpg
    }

}