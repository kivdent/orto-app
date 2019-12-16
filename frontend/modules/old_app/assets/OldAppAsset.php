<?php

/*
 * Комплект ресурсов для старой версии приложения
 */

namespace frontend\modules\old_app\assets;

use yii\web\AssetBundle;

/**
 * Description of OldAppAsset
 *
 * @author kivdent
 */
class OldAppAsset extends AssetBundle {

    public $sourcePath = '@frontend/modules/old_app/assets/files';
    public $css = [
        'main2.css'
    ];
    public $js = [
        'ShowPat.js',
        'find.js',
        'functions.js',
        'gig_index.js',
        'insert.js',
        'manip.js',
        'spisok.js',
        'jumper.js',
        'disp.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
