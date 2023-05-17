<?php

namespace common\assets\vueNpmAssets;

class VueDmi extends \yii\web\AssetBundle
{
    public $sourcePath = "@npm/vue-demi/lib/";
    public $js = ['index.iife.js'];
    public $depends = [
        'common\assets\vueNpmAssets\Vue3Asset',
    ];
}