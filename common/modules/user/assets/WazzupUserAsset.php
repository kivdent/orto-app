<?php

namespace common\modules\user\assets;

class WazzupUserAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/modules/user/assets/files';

    public $js = [
        'WazzupUserAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
       // '\common\modules\notifier\assets\CommunicationsCenterAsset'
    ];
}