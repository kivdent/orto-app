<?php

namespace common\assets\vueNpmAssets;

class Vue3Asset extends \yii\web\AssetBundle
{
    public $sourcePath = '@npm/vue/dist/';
    public $js = [
        'vue.global.js'
    ];
}