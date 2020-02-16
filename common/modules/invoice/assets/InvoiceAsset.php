<?php


namespace common\modules\invoice\assets;


use yii\web\AssetBundle;

class InvoiceAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/invoice/assets/files';

    public $js = [
        'InvoiceAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}