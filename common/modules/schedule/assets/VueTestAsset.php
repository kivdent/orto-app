<?php

namespace common\modules\schedule\assets;

class VueTestAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/modules/schedule/assets/files';

    public $js = [
        'VueTestAsset.js'
    ];
    public $depends = [
       'common\assets\VueAsset'
    ];
}