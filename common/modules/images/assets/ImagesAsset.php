<?php


namespace common\modules\images\assets;


use yii\web\AssetBundle;

class ImagesAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/images/assets/files';

    public $js = [
        'ImagesAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}