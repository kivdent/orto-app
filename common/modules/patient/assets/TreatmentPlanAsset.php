<?php

namespace common\modules\patient\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class TreatmentPlanAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/patient/assets/files';

    public $js = [
        'TreatmentPlanAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
