<?php

namespace common\modules\patient\widgets\assets;

use yii\web\AssetBundle;

class PatientFindModalAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/patient/widgets/assets/files';

    public $js = [
        'find-patient-modal.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',

    ];
}