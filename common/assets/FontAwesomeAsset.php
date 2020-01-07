<?php


namespace common\assets;


use yii\web\AssetBundle;
use yii\web\View;

class FontAwesomeAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $js = [
        // font awesome free version (can be overridden from yii2 asset manager)
        'https://kit.fontawesome.com/3d5f1accca.js'
    ];

    /**
     * @inheritdoc
     */
    public $jsOptions = [
        'position' => View::POS_HEAD,
        'defer' => true,
        'crossorigin' => 'anonymous'
    ];
}