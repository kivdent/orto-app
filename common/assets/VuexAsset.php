<?php

namespace common\assets;

use yii\web\AssetBundle;

class VuexAsset extends AssetBundle
{

    public $sourcePath = '@common/assets/files/vuex/';
    public $js = [
        'vuex.global.js'
    ];
}