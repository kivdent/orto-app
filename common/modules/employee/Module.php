<?php

namespace common\modules\employee;

use common\abstractClasses\WorkModule;
use Yii;

/**
 * employee module definition class
 */
class Module extends WorkModule {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\employee\controllers';
    public $defaultRoute = 'manage';
    public $moduleName = "Cотрудники";

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();

        Yii::configure($this, require __DIR__ . '/config.php');
        ;
    }

}
