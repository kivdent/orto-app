<?php

namespace common\modules\notifier\assets;

use yii\web\AssetBundle;

class CommunicationsCenterAsset  extends AssetBundle
{
    public $sourcePath = '@common/modules/notifier/assets/files';

    public $js = [
        'CommunicationsCenterAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}