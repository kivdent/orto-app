<?php

namespace common\modules\invoice;

use common\abstractClasses\WorkModule;
use Yii;

/**
 * invoice module definition class
 */
class Module extends WorkModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\invoice\controllers';
    public $defaultRoute = 'manage';
    public $moduleName = "Счета";
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
