<?php

namespace common\modules\schedule\assets;

use yii\web\AssetBundle;

class RecorderAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/schedule/assets/files';

    public $js = [
        'RecorderAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}