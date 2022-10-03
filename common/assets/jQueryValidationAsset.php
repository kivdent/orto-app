<?php

namespace common\assets;

class jQueryValidationAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/assets/files';
    public $js = [
        'jquery-validation/dist/jquery.validate.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}