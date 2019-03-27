<?php

/*
 * Комплект ресурсов для старой версии приложения
 */

namespace frontend\modules\old_app\assets;

use yii\web\AssetBundle;

/**
 * Description of OldAppAsset
 *
 * @author kivde
 */
class OldAppAsset extends AssetBundle {

    public $sourcePath = '@frontend/modules/old_app/files';
    public $css = [
        'main2.css'
    ];
    public $js = [
        'js/ShowPat.js',
         'js/find.js',
         'js/functions.js',
         'js/gig_index.js',
         'js/insert.js',
         'js/manip.js',
         'js/spisok.js',
    ];
    public $depends = [];

}
