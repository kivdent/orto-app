<?php

namespace common\modules\schedule\assets;

class CallTaskAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/modules/schedule/assets/files';

    public $js = [
        'CallTaskAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}