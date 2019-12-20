<?php


namespace common\assets;


use yii\web\AssetBundle;

class PrintAsset extends AssetBundle
{
    public $sourcePath = '@common/assets/files';
    public $css = [
        'print.css'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}