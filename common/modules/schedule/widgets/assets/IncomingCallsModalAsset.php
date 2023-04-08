<?php

namespace common\modules\schedule\widgets\assets;

class IncomingCallsModalAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/modules/schedule/widgets/assets/files';

    public $js = [
        'IncomingCallsModalAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',

    ];
}