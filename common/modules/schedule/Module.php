<?php

namespace common\modules\schedule;

use common\abstractClasses\WorkModule;
use Yii;

/**
 * schedule module definition class
 */
class Module extends WorkModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\schedule\controllers';
    public $defaultRoute = 'manage';
    public $moduleName = "Расписание";
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        Yii::configure($this, require __DIR__ . '/config.php');
    }
}
