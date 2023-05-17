<?php

namespace common\assets\vueNpmAssets;

class PiniaNpmAsset extends \yii\web\AssetBundle
{
    public $sourcePath = "@npm/pinia/dist/";
    public $js = ["pinia.iife.js"];

    public $depends=[
        '\common\assets\vueNpmAssets\Vue3Asset',
        'common\assets\vueNpmAssets\VueDmi',

    ];
}