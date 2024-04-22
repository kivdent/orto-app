<?php

namespace common\modules\patient\assets;

class PatientCommunicationsCentre extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/modules/patient/assets/files';

    public $js = [
        'PatientCommunicationsCentre.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}