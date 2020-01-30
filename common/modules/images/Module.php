<?php

namespace common\modules\images;

use common\abstractClasses\WorkModule;
use Yii;

/**
 * images module definition class
 */
class Module extends WorkModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\images\controllers';
    public $defaultRoute = 'manage';
    public $moduleName = "Изображения";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        Yii::configure($this, require __DIR__ . '/config.php');

    }
}
