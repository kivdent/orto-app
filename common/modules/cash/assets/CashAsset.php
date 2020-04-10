<?php


namespace common\modules\cash\assets;


use yii\web\AssetBundle;

class CashAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/cash/assets/files';

    public $js = [
        'cash.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',

    ];
}