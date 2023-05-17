<?php

namespace common\modules\patient\assets;

use yii\web\AssetBundle;

class TreatmentPlanVueAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/patient/assets/files/treatment_plan_vue_asset/';

    public $js = [
        'treatment_plan_vue_asset.js',
    ];
    public $depends = [
        'common\assets\vueNpmAssets\Vue3Asset',
        'common\assets\vueNpmAssets\PiniaNpmAsset',
        'common\assets\VuexAsset',
        'common\assets\ElementsAsset',
    ];

}