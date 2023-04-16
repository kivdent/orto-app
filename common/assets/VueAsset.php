<?php

namespace common\assets;

use yii\web\AssetBundle;

class VueAsset extends AssetBundle
{

    public $sourcePath = '@common/assets/files/vue-asset/';
    public $js = [
        'vue.js'
    ];
}