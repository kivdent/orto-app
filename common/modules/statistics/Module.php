<?php

namespace common\modules\statistics;

use common\abstractClasses\WorkModule;
use Yii;

/**
 * statistics module definition class
 */
class Module extends WorkModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\statistics\controllers';

    public $defaultRoute = 'revenue';
    public $moduleName = "Статистика";
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
