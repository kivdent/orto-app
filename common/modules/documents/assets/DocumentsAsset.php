<?php
namespace common\modules\documents\assets;

use yii\web\AssetBundle;

class DocumentsAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/documents/assets/files';

    public $js = [
        'DocumentsAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}