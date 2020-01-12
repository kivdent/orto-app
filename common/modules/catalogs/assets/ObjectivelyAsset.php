<?php
namespace common\modules\catalogs\assets;
use yii\web\AssetBundle;

class ObjectivelyAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/catalogs/assets/files';

    public $js = [
        'objectivelyAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\assets\FontAwesomeAsset',
    ];
}