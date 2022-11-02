<?php

namespace common\modules\schedule\assets;

class AppointmentAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/modules/schedule/assets/files';

    public $js = [
        'AppointmentAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}