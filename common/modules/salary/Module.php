<?php

namespace common\modules\salary;

use common\abstractClasses\WorkModule;
use Yii;
/**
 * recall module definition class
 */
class Module extends WorkModule {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\salary\controllers';
//    public $defaultRoute = 'manage';
    public $moduleName = "Зароботная плата";



    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();

        Yii::configure($this, require __DIR__ . '/config.php');
        ;
    }

}
