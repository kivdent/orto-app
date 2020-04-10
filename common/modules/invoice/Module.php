<?php

namespace common\modules\invoice;

use common\abstractClasses\WorkModule;

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
    public $moduleName = "Счёт";
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
