<?php

namespace common\modules\schedule\widgets\assets;

class AppointmentModalAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/modules/schedule/widgets/assets/files';

    public $js = [
        'AppointmentModalAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}