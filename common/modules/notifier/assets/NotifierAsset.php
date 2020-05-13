<?php


namespace common\modules\notifier\assets;


use yii\web\AssetBundle;

class NotifierAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/notifier/assets/files';

    public $js = [
        'NotifierAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}