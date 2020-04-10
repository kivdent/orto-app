<?php


namespace common\modules\invoice\widgets\modalTable\assets;


use yii\web\AssetBundle;

class InvoiceModalAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/invoice/widgets/modalTable/assets/files';

    public $js = [
        'invoice-modal.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',

    ];
}