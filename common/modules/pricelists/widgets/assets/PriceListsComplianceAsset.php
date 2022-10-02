<?php

namespace common\modules\pricelists\widgets\assets;

use yii\web\AssetBundle;

class PriceListsComplianceAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/pricelists/widgets/assets/files';
    public $js = [
        'PricelistsCoplianceAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}