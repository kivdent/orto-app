<?php

namespace common\modules\archive;

use common\abstractClasses\WorkModule;
use Yii;

/**
 * archive module definition class
 */
class Module extends WorkModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\archive\controllers';

    /**
     * {@inheritdoc}
     */

    public $defaultRoute = 'manage';
    public $moduleName = "Работа с архивом";

    public function init()
    {
        parent::init();
        Yii::configure($this, require __DIR__ . '/config.php');
        // custom initialization code goes here
    }
}
