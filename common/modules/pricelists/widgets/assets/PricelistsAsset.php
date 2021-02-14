<?php


namespace common\modules\pricelists\widgets\assets;


use yii\web\AssetBundle;

class PricelistsAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/pricelists/widgets/assets/files';
    public $js = [
        'PricelistsAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}