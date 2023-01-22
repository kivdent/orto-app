<?php

namespace common\modules\schedule\widgets\assets;

class CallListTasksModalAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/modules/schedule/widgets/assets/files';

    public $js = [
        'CallListTasksModalAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',

    ];
}