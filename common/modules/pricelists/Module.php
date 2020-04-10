<?php

namespace common\modules\pricelists;

use common\abstractClasses\WorkModule;
use Yii;

/**
 * pricelists module definition class
 */
class Module extends WorkModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\pricelists\controllers';
    public $defaultRoute = 'manage';
    public $moduleName = "Прейскуранты";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        Yii::configure($this, require __DIR__ . '/config.php');
        // custom initialization code goes here
    }
}
