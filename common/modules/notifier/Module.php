<?php

namespace common\modules\notifier;

use common\abstractClasses\WorkModule;
use Yii;

/**
 * notifier module definition class
 */
class Module extends WorkModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\notifier\controllers';
    public $defaultRoute = 'manage';
    public $moduleName = "Оповещения";
    /**
     * {@inheritdoc}
     */


    public function init()
    {
        parent::init();
        Yii::configure($this, require __DIR__ . '/config.php');
    }
}
