<?php

namespace common\assets;

class jQueryValidationAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/assets/files/jquery-validation/dist/';
    public $js = [
        'jquery.validate.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}