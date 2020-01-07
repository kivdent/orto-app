<?php


namespace common\modules\patient\assets;


use yii\web\AssetBundle;

class MedicalRecordAsset extends AssetBundle
{

    public $sourcePath = '@common/modules/patient/assets/files';

    public $js = [
        'MedicalRecordAsset.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\assets\FontAwesomeAsset',
    ];

}